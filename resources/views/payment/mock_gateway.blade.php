@extends('layouts.app')

@section('title', 'درگاه پرداخت آنلاین شبیه‌سازی‌شده | شاپرک')

@section('content')

<div style="max-width: 580px; margin: 30px auto;">
    <!-- Gateway Header with Iranian banking style -->
    <div style="background: #2563eb; color: #fff; border-radius: 20px 20px 0 0; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 12px; opacity: .85;">سامانه پرداخت الکترونیک شاپرک</div>
            <div style="font-size: 18px; font-weight: 800;">درگاه پرداخت اینترنتی {{ $gatewayName }}</div>
        </div>
        @if($isSandbox)
            <div style="background: rgba(255,255,255,.2); padding: 4px 12px; border-radius: 99px; font-size: 12px;">
                شبیه‌ساز تستی (Sandbox)
            </div>
        @endif
    </div>

    <div class="box" style="border-radius: 0 0 20px 20px; border-top: 0;">
        <div style="background: var(--bg); border: 1px solid var(--line); border-radius: 16px; padding: 16px; margin-bottom: 22px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                <span class="muted">پذیرنده:</span>
                <b>فروشگاه پوشاک AtilaShop</b>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                <span class="muted">شماره سفارش:</span>
                <b dir="ltr">{{ $order->order_number }}</b>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; border-top: 1px dashed var(--line); padding-top: 10px; margin-top: 8px;">
                <span>مبلغ قابل پرداخت:</span>
                <span style="color: var(--brand);">{{ $order->formatted_total }}</span>
            </div>
        </div>

        <!-- Dummy Card Fields for realism -->
        <div style="display: grid; gap: 14px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">شماره کارت ۱۶ رقمی</label>
                <input type="text" value="۶۰۳۷ - ۹۹۱۸ - **** - ****" disabled style="opacity: .7; text-align: center; letter-spacing: 2px;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">کد CVV2</label>
                    <input type="password" value="987" disabled style="opacity: .7; text-align: center;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">تاریخ انقضا</label>
                    <input type="text" value="06 / 28" disabled style="opacity: .7; text-align: center;">
                </div>
            </div>
        </div>

        <div class="alert alert-info" style="font-size: 13px; margin-bottom: 20px;">
            <svg class="ic"><use href="#i-shield"/></svg>
            <span>این درگاه به صورت شبیه‌سازی جهت تست کامل فرایند خرید و ثبت تراکنش است. لطفاً نتیجه‌ی تست را انتخاب کنید:</span>
        </div>

        <form method="POST" action="{{ route('payment.process', $order->id) }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1.2fr .8fr; gap: 12px;">
                <button type="submit" name="action" value="success" class="btn" style="background: #10b981; color: #fff; justify-content: center; font-size: 15px;">
                    <svg class="ic"><use href="#i-check"/></svg>
                    پرداخت موفقیت‌آمیز
                </button>

                <button type="submit" name="action" value="fail" class="btn o" style="border-color: var(--sale); color: var(--sale); justify-content: center; font-size: 14px;">
                    <svg class="ic"><use href="#i-x"/></svg>
                    انصراف / پرداخت ناموفق
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
