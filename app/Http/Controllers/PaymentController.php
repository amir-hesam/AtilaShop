<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function gateway($orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        if ($order->status === 'پرداخت شده') {
            return redirect()->route('orders.show', $order->id)->with('info', 'این سفارش قبلاً پرداخت شده است.');
        }

        $activeGatewayKey = Setting::get('active_online_gateway', 'zarinpal');
        $gatewayNames = [
            'zarinpal' => 'زرین‌پال (ZarinPal)',
            'zibal' => 'زیبال (Zibal)',
            'payping' => 'پی‌پینگ (PayPing)',
            'mellat' => 'به‌پرداخت ملت (شاپرک)',
            'idpay' => 'آیدی‌پی (IDPay)',
        ];
        $gatewayName = $gatewayNames[$activeGatewayKey] ?? 'درگاه الکترونیک شاپرک';
        $isSandbox = Setting::get('gateway_sandbox', true);

        return view('payment.mock_gateway', compact('order', 'gatewayName', 'isSandbox'));
    }

    public function process(Request $request, $orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        $action = $request->input('action');

        if ($action === 'success') {
            $trackingCode = 'ONL-' . rand(100000, 999999);
            $order->update([
                'status' => 'پرداخت شده',
                'tracking_code' => $trackingCode,
            ]);

            return redirect()->route('orders.show', $order->id)
                ->with('success', "پرداخت با موفقیت انجام شد! کد پیگیری پرداخت شما: {$trackingCode}");
        }

        $order->update([
            'status' => 'پرداخت ناموفق',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'تراکنش پرداخت آنلاین ناموفق بود یا توسط کاربر لغو گردید. می‌توانید مجدداً تلاش کنید.');
    }
}
