@extends('layouts.app')

@section('title', 'اطلاعات پرداخت کارت‌به‌کارت | AtilaShop')

@section('content')

<div style="max-width: 620px; margin: 30px auto;">
    <div class="box">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: color-mix(in srgb, var(--brand) 15%, transparent); color: var(--brand); display: grid; place-items: center; margin: 0 auto 12px;">
                <svg class="ic" style="width: 28px; height: 28px;"><use href="#i-shield"/></svg>
            </div>
            <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 6px;">اطلاعات پرداخت کارت‌به‌کارت</h2>
            <p class="muted" style="margin: 0; font-size: 14px;">سفارش شماره: <b>{{ $order->order_number }}</b></p>
        </div>

        <div style="background: var(--bg); border: 1px solid var(--line); border-radius: 18px; padding: 20px; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <span class="muted" style="font-size: 14px;">مبلغ دقیق جهت واریز:</span>
                <span style="font-size: 20px; font-weight: 800; color: var(--brand);">{{ $order->formatted_total }}</span>
            </div>

            <div style="border-top: 1px dashed var(--line); padding-top: 14px; margin-top: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span class="muted" style="font-size: 14px;">شماره کارت فروشگاه:</span>
                    <button type="button" class="btn o" style="padding: 4px 10px; font-size: 11px;" onclick="copyCard()">کپی شماره کارت</button>
                </div>
                <div id="card-num" style="font-size: 20px; font-weight: 800; letter-spacing: 2px; text-align: center; background: var(--card); padding: 10px; border-radius: 12px; border: 1px solid var(--line);" dir="ltr">
                    {{ $cardDetails['card_number'] }}
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 12px; font-size: 13px;">
                    <span class="muted">صاحب حساب:</span>
                    <b>{{ $cardDetails['card_holder_name'] }} ({{ $cardDetails['bank_name'] }})</b>
                </div>

                @if(!empty($cardDetails['card_iban']))
                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 13px;">
                        <span class="muted">شماره شبا:</span>
                        <span dir="ltr" style="font-weight: 600;">{{ $cardDetails['card_iban'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="alert alert-info" style="font-size: 13px; margin-bottom: 24px;">
            <svg class="ic"><use href="#i-check"/></svg>
            <span>{{ $cardDetails['card_instructions'] }}</span>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-inline-start: 18px; font-size: 13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.submit_tracking', $order->id) }}" enctype="multipart/form-data">
            @csrf

            <!-- Upload Receipt Image -->
            <div style="background: var(--bg); border: 2px dashed var(--line); border-radius: 16px; padding: 18px; text-align: center; margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 6px; cursor: pointer;">
                    📸 بارگذاری تصویر رسید / فیش واریزی (عکس یا اسکرین‌شات)
                </label>
                <div class="muted" style="font-size: 12px; margin-bottom: 10px;">
                    فرمت‌های JPG, PNG, WEBP تا سقف ۵ مگابایت
                </div>

                @if($order->receipt_image_url)
                    <div style="margin-bottom: 12px;">
                        <div style="font-size: 12px; color: var(--muted); margin-bottom: 4px;">فیش قبلاً ارسال شده:</div>
                        <img src="{{ $order->receipt_image_url }}" alt="فیش واریز" style="max-height: 140px; border-radius: 10px; border: 1px solid var(--line); display: block; margin: 0 auto;">
                    </div>
                @endif

                <input type="file" name="receipt_image" id="receipt-input" accept="image/*" style="max-width: 280px; margin: 0 auto; display: block;" onchange="previewReceipt(this)">
                <div id="receipt-preview-box" style="margin-top: 12px; display: none;">
                    <div style="font-size: 12px; color: var(--muted); margin-bottom: 4px;">پیش‌نمایش تصویر فیش:</div>
                    <img id="receipt-preview" src="" alt="پیش‌نمایش فیش" style="max-height: 150px; border-radius: 10px; border: 1px solid var(--line); display: block; margin: 0 auto;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">
                    کد پیگیری یا شماره ارجاع بانکی (اختیاری در صورت آپلود فیش):
                </label>
                <input type="text" name="tracking_code" value="{{ old('tracking_code', $order->tracking_code) }}" placeholder="مثلاً: TRX-983142 یا شماره پیگیری" dir="ltr" style="font-weight: 700; text-align: center;">
            </div>

            <button type="submit" class="btn brand" style="width: 100%; justify-content: center; font-size: 16px;">
                ثبت فیش و ارسال برای بررسی مدیر فروشگاه
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('orders.show', $order->id) }}" class="muted" style="font-size: 13px;">مشاهده جزئیات این سفارش</a>
        </div>
    </div>
</div>

<script>
    function copyCard() {
        navigator.clipboard.writeText('{{ preg_replace('/[^0-9]/', '', $cardDetails['card_number']) }}');
        toast('شماره کارت کپی شد.');
    }

    function previewReceipt(input) {
        const previewBox = document.getElementById('receipt-preview-box');
        const previewImg = document.getElementById('receipt-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewBox.style.display = 'none';
        }
    }
</script>

@endsection
