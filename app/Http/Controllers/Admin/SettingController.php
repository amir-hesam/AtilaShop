<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $gateways = [
            'zarinpal' => 'زرین‌پال (ZarinPal)',
            'zibal' => 'زیبال (Zibal)',
            'payping' => 'پی‌پینگ (PayPing)',
            'mellat' => 'به‌پرداخت ملت (بانک ملت)',
            'idpay' => 'آیدی‌پی (IDPay)',
        ];

        $settings = [
            'payment_card_enabled' => Setting::get('payment_card_enabled', true),
            'card_bank_name' => Setting::get('card_bank_name', 'بانک ملی ایران'),
            'card_number' => Setting::get('card_number', '6037-9975-8821-4321'),
            'card_holder_name' => Setting::get('card_holder_name', 'فروشگاه پوشاک آتیلاشاپ'),
            'card_iban' => Setting::get('card_iban', 'IR120170000000123456789012'),
            'card_instructions' => Setting::get('card_instructions', 'پس از واریز به شماره کارت، کد پیگیری فیش را ثبت فرمایید.'),

            'payment_online_enabled' => Setting::get('payment_online_enabled', true),
            'active_online_gateway' => Setting::get('active_online_gateway', 'zarinpal'),
            'zarinpal_merchant_id' => Setting::get('zarinpal_merchant_id', ''),
            'zibal_merchant_id' => Setting::get('zibal_merchant_id', ''),
            'gateway_sandbox' => Setting::get('gateway_sandbox', true),

            'free_shipping_threshold' => Setting::get('free_shipping_threshold', 2000000),
            'support_phone' => Setting::get('support_phone', '۰۲۱-۸۸۸۸۹۹۹۹'),
            'announcement_bar_text' => Setting::get('announcement_bar_text', 'ارسال رایگان برای خرید بالای ۲ میلیون تومان · پرداخت کارت‌به‌کارت یا درگاه آنلاین'),
        ];

        return view('admin.settings.index', compact('settings', 'gateways'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'card_bank_name' => ['nullable', 'string', 'max:100'],
            'card_number' => ['nullable', 'string', 'max:50'],
            'card_holder_name' => ['nullable', 'string', 'max:150'],
            'card_iban' => ['nullable', 'string', 'max:50'],
            'card_instructions' => ['nullable', 'string', 'max:500'],
            'active_online_gateway' => ['required', 'string', 'in:zarinpal,zibal,payping,mellat,idpay'],
            'zarinpal_merchant_id' => ['nullable', 'string', 'max:100'],
            'zibal_merchant_id' => ['nullable', 'string', 'max:100'],
            'free_shipping_threshold' => ['required', 'integer', 'min:0'],
            'support_phone' => ['nullable', 'string', 'max:50'],
            'announcement_bar_text' => ['nullable', 'string', 'max:255'],
        ]);

        // کارت به کارت
        Setting::set('payment_card_enabled', $request->has('payment_card_enabled'), 'payment');
        Setting::set('card_bank_name', $request->card_bank_name, 'payment');
        Setting::set('card_number', $request->card_number, 'payment');
        Setting::set('card_holder_name', $request->card_holder_name, 'payment');
        Setting::set('card_iban', $request->card_iban, 'payment');
        Setting::set('card_instructions', $request->card_instructions, 'payment');

        // درگاه پرداخت آنلاین
        Setting::set('payment_online_enabled', $request->has('payment_online_enabled'), 'payment');
        Setting::set('active_online_gateway', $request->active_online_gateway, 'payment');
        Setting::set('zarinpal_merchant_id', $request->zarinpal_merchant_id, 'payment');
        Setting::set('zibal_merchant_id', $request->zibal_merchant_id, 'payment');
        Setting::set('gateway_sandbox', $request->has('gateway_sandbox'), 'payment');

        // عمومی
        Setting::set('free_shipping_threshold', $request->free_shipping_threshold, 'general');
        Setting::set('support_phone', $request->support_phone, 'general');
        Setting::set('announcement_bar_text', $request->announcement_bar_text, 'general');

        return back()->with('success', 'تنظیمات روش‌های پرداخت و درگاه‌ها با موفقیت ذخیره شد.');
    }
}
