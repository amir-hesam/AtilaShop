<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('receiver_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('tracking_code', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $statuses = [
            'در انتظار پرداخت',
            'در انتظار تأیید پرداخت',
            'تأیید پرداخت',
            'در حال آماده‌سازی و بسته‌بندی',
            'تحویل به پست / ارسال شده',
            'تحویل داده شد',
            'لغو شده',
        ];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        $statuses = [
            'در انتظار پرداخت',
            'در انتظار تأیید پرداخت',
            'تأیید پرداخت',
            'در حال آماده‌سازی و بسته‌بندی',
            'تحویل به پست / ارسال شده',
            'تحویل داده شد',
            'لغو شده',
        ];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => ['required', 'string'],
            'tracking_code' => ['nullable', 'string', 'max:100'],
            'status_note' => ['nullable', 'string', 'max:500'],
        ]);

        $order->status = $request->status;
        if ($request->filled('tracking_code')) {
            $order->tracking_code = $request->tracking_code;
        }
        if ($request->filled('status_note')) {
            $order->notes = ($order->notes ? $order->notes . "\n" : '') . 'یادداشت وضعیت ادمین: ' . $request->status_note;
        }
        $order->save();

        // ارسال نوتیفیکیشن اختصاصی برای کاربر در هر تغییر وضعیت
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'به‌روزرسانی وضعیت سفارش ' . $order->order_number,
            'message' => 'وضعیت سفارش شما به «' . $order->status . '» تغییر یافت.' . ($request->filled('tracking_code') ? ' کد رهگیری پستی مرسوله: ' . $request->tracking_code : ''),
            'type' => 'order_status',
            'is_read' => false,
        ]);

        return back()->with('success', "وضعیت سفارش {$order->order_number} به «{$order->status}» به‌روزرسانی شد و نوتیفیکیشن برای مشتری ارسال گردید.");
    }
}
