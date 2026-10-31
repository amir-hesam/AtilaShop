@extends('layouts.app')

@section('title', 'ثبت نهایی سفارش و پرداخت | AtilaShop')

@section('content')

<div style="margin: 20px 0 28px;">
    <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 6px;">ثبت نهایی سفارش و پرداخت</h1>
    <p class="muted" style="margin: 0;">اطلاعات گیرنده و آدرس پستی خود را با دقت وارد کنید.</p>
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

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf

    <div style="display: grid; grid-template-columns: 1.4fr .8fr; gap: 28px; align-items: start;">
        <!-- Customer Info Form -->
        <div class="box">
            <h3 style="font-size: 18px; font-weight: 800; margin: 0 0 18px; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
                مشخصات تحویل‌گیرنده و آدرس
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نام و نام خانوادگی گیرنده *</label>
                    <input type="text" name="receiver_name" value="{{ old('receiver_name', $user->name) }}" required placeholder="مثلاً: سارا راد">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">شماره موبایل (فرمت ۰۹) *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required dir="ltr" placeholder="09123456789">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">آدرس کامل پستی (شامل استان، شهر، خیابان، پلاک و واحد) *</label>
                <textarea name="address" rows="3" required placeholder="مثلاً: تهران، میدان ونک، خیابان ملاصدرا، پلاک ۲۴، زنگ ۳">{{ old('address') }}</textarea>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">توضیحات و یادداشت سفارش (اختیاری)</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="مثلاً: بعد از ساعت ۱۴ تحویل داده شود">
            </div>

            <h3 style="font-size: 18px; font-weight: 800; margin: 24px 0 16px; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
                انتخاب روش پرداخت
            </h3>

            <div style="display: grid; gap: 12px;">
                @if($onlineEnabled)
                    <!-- Online Gateway Option -->
                    <label style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; border: 1px solid var(--line); border-radius: 16px; cursor: pointer; background: var(--bg);">
                        <input type="radio" name="payment_method" value="online" checked style="width: auto;">
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 15px;">پرداخت آنلاین اینترنتی (درگاه {{ $activeGatewayTitle }})</div>
                            <div class="muted" style="font-size: 13px;">پرداخت مستقیم با کلیه کارت‌های عضو شبکه شتاب</div>
                        </div>
                        <svg class="ic" style="color: var(--brand);"><use href="#i-shield"/></svg>
                    </label>
                @endif

                @if($cardEnabled)
                    <!-- Card to Card Option -->
                    <label style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; border: 1px solid var(--line); border-radius: 16px; cursor: pointer; background: var(--bg);">
                        <input type="radio" name="payment_method" value="card_transfer" {{ (!$onlineEnabled || old('payment_method') === 'card_transfer') ? 'checked' : '' }} style="width: auto;">
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 15px;">کارت‌به‌کارت بانکی</div>
                            <div class="muted" style="font-size: 13px;">واریز مستقیم به شماره کارت فروشگاه و ثبت کد پیگیری / شماره فیش</div>
                        </div>
                        <svg class="ic" style="color: var(--brand);"><use href="#i-bag"/></svg>
                    </label>
                @endif

                @if(!$onlineEnabled && !$cardEnabled)
                    <div class="alert alert-error">
                        در حال حاضر هیچ روش پرداختی توسط فروشگاه فعال نشده است. لطفاً با پشتیبانی تماس بگیرید.
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="box" style="position: sticky; top: 90px;">
            <h3 style="font-size: 18px; font-weight: 800; margin: 0 0 16px; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
                اقلام سبد خرید
            </h3>

            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 280px; overflow-y: auto; margin-bottom: 16px;">
                @foreach($cart as $item)
                    @php
                        $hue = ($item['hues'] && isset($item['hues'][$item['ci']])) ? $item['hues'][$item['ci']] : 345;
                    @endphp
                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 10px; border-bottom: 1px solid var(--line);">
                        <div class="art" style="--h: {{ $hue }}; width: 48px; height: 58px; border-radius: 10px; flex: none;">
                            <svg class="g" viewBox="0 0 100 130" style="width: 55%; filter: none;"><use href="#{{ $item['icon'] ?? 'tee' }}"/></svg>
                        </div>
                        <div style="flex: 1; font-size: 13px;">
                            <div style="font-weight: 700;">{{ $item['name'] }}</div>
                            <div class="muted">سایز: {{ $item['size'] }} × {{ $item['qty'] }}</div>
                        </div>
                        <div style="font-weight: 700; font-size: 14px;">
                            {{ number_format($item['price'] * $item['qty']) }} تومان
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px;">
                <span class="muted">هزینه ارسال:</span>
                <span style="font-weight: 600; color: {{ $total >= 2000000 ? 'var(--success)' : 'inherit' }};">
                    {{ $total >= 2000000 ? 'رایگان' : '۵۰,۰۰۰ تومان' }}
                </span>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 800; margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--line);">
                <span>مبلغ قابل پرداخت:</span>
                <span style="color: var(--brand);">{{ number_format($total) }} تومان</span>
            </div>

            <button type="submit" class="btn brand" style="width: 100%; justify-content: center; margin-top: 20px; font-size: 16px;">
                تأیید و رفتن به مرحله پرداخت
            </button>

            <div style="background: var(--brand-light); border: 1px solid var(--brand-border); border-radius: 16px; padding: 12px 14px; margin-top: 16px; font-size: 12.5px; line-height: 1.6; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(224, 69, 123, 0.08);">
                <svg class="ic" style="color: var(--brand); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-box-lock"/></svg>
                <span><b style="color: var(--brand);">ارسال کاملاً محرمانه:</b> مرسوله در کارتن پستی مات و بدون درج نام کالا یا لوگو ارسال می‌شود.</span>
            </div>
        </div>
    </div>
</form>

@endsection
