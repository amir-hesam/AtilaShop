<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'سبد خرید شما خالی است.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $user = Auth::user();

        // دریافت وضعیت فعال/غیرفعال بودن درگاه‌ها از تنظیمات
        $onlineEnabled = Setting::get('payment_online_enabled', true);
        $cardEnabled = Setting::get('payment_card_enabled', true);
        $activeGatewayKey = Setting::get('active_online_gateway', 'zarinpal');

        $gatewayTitles = [
            'zarinpal' => 'زرین‌پال',
            'zibal' => 'زیبال',
            'payping' => 'پی‌پینگ',
            'mellat' => 'به‌پرداخت ملت',
            'idpay' => 'آیدی‌پی',
        ];
        $activeGatewayTitle = $gatewayTitles[$activeGatewayKey] ?? 'درگاه اینترنتی شتاب';

        return view('orders.checkout', compact('cart', 'total', 'user', 'onlineEnabled', 'cardEnabled', 'activeGatewayTitle'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'سبد خرید شما خالی است.');
        }

        $onlineEnabled = Setting::get('payment_online_enabled', true);
        $cardEnabled = Setting::get('payment_card_enabled', true);

        $request->validate([
            'receiver_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
            'address' => ['required', 'string', 'min:10'],
            'payment_method' => ['required', 'in:online,card_transfer'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'receiver_name.required' => 'نام و نام خانوادگی گیرنده الزامی است.',
            'phone.required' => 'شماره موبایل گیرنده الزامی است.',
            'phone.regex' => 'شماره موبایل نامعتبر است (فرمت صحیح: ۰۹۱۲۳۴۵۶۷۸۹ و ۱۱ رقم).',
            'address.required' => 'آدرس کامل پستی الزامی است.',
            'address.min' => 'آدرس باید حداقل ۱۰ کاراکتر باشد.',
            'payment_method.required' => 'انتخاب روش پرداخت الزامی است.',
            'payment_method.in' => 'روش پرداخت انتخابی معتبر نیست.',
        ]);

        // اعتبارسنجی وضعیت درگاه انتخابی بر اساس تنظیمات ادمین
        if ($request->payment_method === 'online' && !$onlineEnabled) {
            throw ValidationException::withMessages([
                'payment_method' => 'درگاه پرداخت آنلاین در حال حاضر توسط مدیریت غیرفعال شده است. لطفاً کارت‌به‌کارت را انتخاب کنید.',
            ]);
        }

        if ($request->payment_method === 'card_transfer' && !$cardEnabled) {
            throw ValidationException::withMessages([
                'payment_method' => 'روش پرداخت کارت‌به‌کارت در حال حاضر توسط مدیریت غیرفعال است. لطفاً پرداخت آنلاین را انتخاب کنید.',
            ]);
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $order = Order::create([
                'order_number' => 'AT-' . rand(1000, 9999),
                'user_id' => Auth::id(),
                'receiver_name' => $request->receiver_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'در انتظار پرداخت',
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'size' => $item['size'],
                    'color_index' => $item['ci'] ?? 0,
                    'unit_price' => $item['price'],
                    'quantity' => $item['qty'],
                    'total_price' => $item['price'] * $item['qty'],
                ]);
            }

            // خالی کردن سبد خرید مطابق FR-18
            session()->forget('cart');

            return $order;
        });

        // ایجاد نوتیفیکیشن ثبت اولیه سفارش
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'ثبت سفارش جدید ' . $order->order_number,
            'message' => 'سفارش شما با مبلغ ' . $order->formatted_total . ' ثبت شد و مرحله اول (ثبت سفارش) تکمیل گردید.',
            'type' => 'order_placed',
            'is_read' => false,
        ]);

        if ($order->payment_method === 'online') {
            return redirect()->route('payment.gateway', $order->id);
        }

        return redirect()->route('orders.card_transfer', $order->id);
    }

    public function userOrders()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function cardTransferView($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);

        // دریافت مشخصات کارت از تنظیمات پایگاه‌داده
        $cardDetails = [
            'bank_name' => Setting::get('card_bank_name', 'بانک ملی ایران'),
            'card_number' => Setting::get('card_number', '6037-9975-8821-4321'),
            'card_holder_name' => Setting::get('card_holder_name', 'فروشگاه پوشاک آتیلاشاپ'),
            'card_iban' => Setting::get('card_iban', 'IR120170000000123456789012'),
            'card_instructions' => Setting::get('card_instructions', 'پس از انتقال وجه از طریق همراه بانک یا عابربانک، کد پیگیری را در کادر زیر ثبت فرمایید.'),
        ];

        return view('orders.card_transfer', compact('order', 'cardDetails'));
    }

    public function submitTrackingCode(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'tracking_code' => ['nullable', 'string', 'max:50'],
            'receipt_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'receipt_image.image' => 'فایل تصویر فیش معتبر نیست.',
            'receipt_image.max' => 'حجم تصویر فیش نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        if (!$request->filled('tracking_code') && !$request->hasFile('receipt_image')) {
            throw ValidationException::withMessages([
                'tracking_code' => 'لطفاً حداقل کد پیگیری یا تصویر فیش واریز را وارد کنید.',
            ]);
        }

        $receiptPath = $order->receipt_image;
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
        }

        $order->update([
            'tracking_code' => $request->tracking_code ?: 'فیش ضمیمه شد',
            'receipt_image' => $receiptPath,
            'status' => 'در انتظار تأیید پرداخت',
        ]);

        // ایجاد نوتیفیکیشن اختصاصی برای کاربر پس از ارسال فیش
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'ثبت موفق فیش پرداخت (سفارش ' . $order->order_number . ')',
            'message' => 'تصویر فیش واریزی شما برای سفارش ' . $order->order_number . ' با موفقیت ثبت شد و در صف بررسی واحد مالی قرار گرفت. نتیجه به‌زودی از طریق پیام و نوار وضعیت به اطلاع شما خواهد رسید.',
            'type' => 'receipt_submitted',
            'is_read' => false,
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'فیش پرداخت شما با موفقیت ثبت شد و در صف بررسی واحد مالی قرار گرفت. وضعیت سفارش شما در نوار پیگیری به‌روزرسانی شد.');
    }

    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->customNotifications()->take(10)->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'type' => $n->type,
                'is_read' => $n->is_read,
                'time_ago' => $n->created_at->diffForHumans(),
                'order_id' => $n->order_id,
                'order_url' => $n->order_id ? route('orders.show', $n->order_id) : null,
            ];
        });

        $unreadCount = $user->unreadCustomNotificationsCount();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAllNotificationsRead()
    {
        Auth::user()->customNotifications()->where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markNotificationRead($id)
    {
        $notification = Auth::user()->customNotifications()->findOrFail($id);
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
