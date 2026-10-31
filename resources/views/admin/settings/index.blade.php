@extends('layouts.admin')

@section('title', 'تنظیمات روش‌های پرداخت و درگاه‌ها | AtilaShop')
@section('breadcrumb', 'پیکربندی شماره کارت، درگاه‌های پرداخت و تنظیمات فروشگاه')

@section('content')

<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 4px;">تنظیمات درگاه‌ها و روش‌های پرداخت</h2>
            <div style="font-size: 13px; color: var(--muted);">
                شماره کارت واریزی را تغییر دهید یا مشخص کنید کدام درگاه‌ها در فروشگاه فعال باشند.
            </div>
        </div>
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

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <!-- 1. تنظیمات کارت‌به‌کارت -->
        <div class="box" style="margin-bottom: 28px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: color-mix(in srgb, var(--brand) 15%, transparent); color: var(--brand); display: grid; place-items: center;">
                        <svg class="ic"><use href="#i-bag"/></svg>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 17px; font-weight: 800;">تنظیمات پرداخت کارت‌به‌کارت</h3>
                        <div style="font-size: 12px; color: var(--muted);">اطلاعات حسابی که در مرحله تسویه‌حساب به مشتری نمایش داده می‌شود</div>
                    </div>
                </div>

                <!-- Toggle Card-to-Card Active/Inactive -->
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 700; background: var(--bg); padding: 8px 16px; border-radius: 99px; border: 1px solid var(--line);">
                    <input type="checkbox" name="payment_card_enabled" value="1" {{ $settings['payment_card_enabled'] ? 'checked' : '' }} style="width: auto;">
                    <span>روش کارت‌به‌کارت فعال باشد</span>
                </label>
            </div>

            <div style="display: grid; grid-template-columns: 1.2fr .8fr; gap: 24px; align-items: start;">
                <div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">نام بانک *</label>
                            <input type="text" name="card_bank_name" id="inp-bank" value="{{ old('card_bank_name', $settings['card_bank_name']) }}" required placeholder="مثلاً: بانک ملی ایران">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">نام صاحب حساب / فروشگاه *</label>
                            <input type="text" name="card_holder_name" id="inp-holder" value="{{ old('card_holder_name', $settings['card_holder_name']) }}" required placeholder="مثلاً: فروشگاه پوشاک آتیلاشاپ">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">شماره کارت ۱۶ رقمی (جهت واریز مشتری) *</label>
                        <input type="text" name="card_number" id="inp-card" value="{{ old('card_number', $settings['card_number']) }}" required dir="ltr" style="font-weight: 700; letter-spacing: 2px; text-align: center;" placeholder="6037-9975-8821-4321">
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">شماره شبا (اختیاری جهت مبالغ بالا)</label>
                        <input type="text" name="card_iban" value="{{ old('card_iban', $settings['card_iban']) }}" dir="ltr" placeholder="IR120170000000123456789012">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">متن راهنمای واریز برای مشتری</label>
                        <textarea name="card_instructions" rows="2">{{ old('card_instructions', $settings['card_instructions']) }}</textarea>
                    </div>
                </div>

                <!-- Visual Bank Card Preview -->
                <div>
                    <div style="font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 8px;">پیش‌نمایش کارت بانکی فروشگاه:</div>
                    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #fff; border-radius: 18px; padding: 22px; box-shadow: 0 10px 25px rgba(0,0,0,.2); position: relative; overflow: hidden; aspect-ratio: 1.6/1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="prev-bank" style="font-size: 14px; font-weight: 700;">{{ $settings['card_bank_name'] }}</span>
                            <span style="font-size: 12px; opacity: .7;">شتاب</span>
                        </div>
                        <div style="width: 38px; height: 28px; background: #e2e8f0; border-radius: 6px; opacity: .85;"></div>
                        <div id="prev-card" style="font-size: 18px; font-weight: 800; letter-spacing: 2px; text-align: center;" dir="ltr">
                            {{ $settings['card_number'] }}
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px;">
                            <span class="muted" style="color: rgba(255,255,255,.6);">صاحب کارت:</span>
                            <span id="prev-holder" style="font-weight: 700;">{{ $settings['card_holder_name'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. تنظیمات درگاه‌های پرداخت آنلاین -->
        <div class="box" style="margin-bottom: 28px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: color-mix(in srgb, #2563eb 15%, transparent); color: #2563eb; display: grid; place-items: center;">
                        <svg class="ic"><use href="#i-shield"/></svg>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 17px; font-weight: 800;">تنظیمات درگاه‌های پرداخت آنلاین</h3>
                        <div style="font-size: 12px; color: var(--muted);">فعال‌سازی درگاه شتاب و انتخاب ارائه‌دهنده درگاه اینترنتی</div>
                    </div>
                </div>

                <!-- Toggle Online Gateway Active/Inactive -->
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 700; background: var(--bg); padding: 8px 16px; border-radius: 99px; border: 1px solid var(--line);">
                    <input type="checkbox" name="payment_online_enabled" value="1" {{ $settings['payment_online_enabled'] ? 'checked' : '' }} style="width: auto;">
                    <span>درگاه پرداخت آنلاین فعال باشد</span>
                </label>
            </div>

            <!-- Gateway Selector -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">
                    انتخاب درگاه پرداخت آنلاین پیش‌فرض:
                </label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px;">
                    @foreach($gateways as $gwKey => $gwName)
                        <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--line); border-radius: 12px; cursor: pointer; background: var(--bg);">
                            <input type="radio" name="active_online_gateway" value="{{ $gwKey }}" {{ $settings['active_online_gateway'] === $gwKey ? 'checked' : '' }} style="width: auto;">
                            <span style="font-size: 13px; font-weight: 600;">{{ $gwName }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">مرچنت کد زرین‌پال (Merchant ID)</label>
                    <input type="text" name="zarinpal_merchant_id" value="{{ old('zarinpal_merchant_id', $settings['zarinpal_merchant_id']) }}" dir="ltr" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">مرچنت کد زیبال (Zibal Merchant)</label>
                    <input type="text" name="zibal_merchant_id" value="{{ old('zibal_merchant_id', $settings['zibal_merchant_id']) }}" dir="ltr" placeholder="zibal">
                </div>
            </div>

            <div style="background: var(--bg); padding: 12px 16px; border-radius: 12px; border: 1px solid var(--line);">
                <label style="display: inline-flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="gateway_sandbox" value="1" {{ $settings['gateway_sandbox'] ? 'checked' : '' }} style="width: auto;">
                    <div>
                        <div style="font-size: 13px; font-weight: 700;">حالت تستی و شبیه‌ساز درگاه (Sandbox / Mock)</div>
                        <div style="font-size: 11px; color: var(--muted);">در این حالت پرداخت‌ها بدون کسر وجه واقعی و با درگاه شبیه‌سازی شاپرک انجام می‌شود.</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- 3. تنظیمات عمومی فروشگاه -->
        <div class="box" style="margin-bottom: 28px;">
            <h3 style="margin: 0 0 16px; font-size: 17px; font-weight: 800; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
                تنظیمات عمومی فروشگاه
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">سقف مبلغ ارسال رایگان (تومان) *</label>
                    <input type="number" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold']) }}" required min="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">شماره تماس پشتیبانی فوتر</label>
                    <input type="text" name="support_phone" value="{{ old('support_phone', $settings['support_phone']) }}">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">متن نوار اعلان بالای سایت (Announcement Bar)</label>
                <input type="text" name="announcement_bar_text" value="{{ old('announcement_bar_text', $settings['announcement_bar_text']) }}">
            </div>
        </div>

        <!-- Submit Button -->
        <div style="display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.dashboard') }}" class="btn o">انصراف</a>
            <button type="submit" class="btn brand" style="padding: 12px 36px; font-size: 15px;">
                ذخیره تمامی تنظیمات
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Live update bank card visual preview
    const inpBank = document.getElementById('inp-bank');
    const inpHolder = document.getElementById('inp-holder');
    const inpCard = document.getElementById('inp-card');

    const prevBank = document.getElementById('prev-bank');
    const prevHolder = document.getElementById('prev-holder');
    const prevCard = document.getElementById('prev-card');

    if (inpBank && prevBank) {
        inpBank.addEventListener('input', () => prevBank.textContent = inpBank.value || 'نام بانک');
    }
    if (inpHolder && prevHolder) {
        inpHolder.addEventListener('input', () => prevHolder.textContent = inpHolder.value || 'صاحب حساب');
    }
    if (inpCard && prevCard) {
        inpCard.addEventListener('input', () => prevCard.textContent = inpCard.value || '---- ---- ---- ----');
    }
</script>
@endsection
