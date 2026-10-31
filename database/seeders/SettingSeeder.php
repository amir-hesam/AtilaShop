<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // تنظیمات کارت‌به‌کارت
            ['key' => 'payment_card_enabled', 'value' => '1', 'group' => 'payment'],
            ['key' => 'card_bank_name', 'value' => 'بانک ملی ایران', 'group' => 'payment'],
            ['key' => 'card_number', 'value' => '6037-9975-8821-4321', 'group' => 'payment'],
            ['key' => 'card_holder_name', 'value' => 'فروشگاه پوشاک آتیلاشاپ', 'group' => 'payment'],
            ['key' => 'card_iban', 'value' => 'IR120170000000123456789012', 'group' => 'payment'],
            ['key' => 'card_instructions', 'value' => 'پس از واریز به شماره کارت، کد پیگیری فیش را ثبت فرمایید.', 'group' => 'payment'],

            // تنظیمات درگاه پرداخت آنلاین
            ['key' => 'payment_online_enabled', 'value' => '1', 'group' => 'payment'],
            ['key' => 'active_online_gateway', 'value' => 'zarinpal', 'group' => 'payment'],
            ['key' => 'zarinpal_merchant_id', 'value' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'group' => 'payment'],
            ['key' => 'zibal_merchant_id', 'value' => 'zibal', 'group' => 'payment'],
            ['key' => 'gateway_sandbox', 'value' => '1', 'group' => 'payment'],

            // تنظیمات عمومی
            ['key' => 'free_shipping_threshold', 'value' => '2000000', 'group' => 'general'],
            ['key' => 'support_phone', 'value' => '۰۲۱-۸۸۸۸۹۹۹۹', 'group' => 'general'],
            ['key' => 'announcement_bar_text', 'value' => 'ارسال رایگان برای خرید بالای ۲ میلیون تومان · پرداخت کارت‌به‌کارت یا درگاه آنلاین', 'group' => 'general'],
        ];

        foreach ($defaults as $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
