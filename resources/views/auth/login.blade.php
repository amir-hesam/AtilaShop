@extends('layouts.app')

@section('title', 'ورود به حساب کاربری | AtilaShop')

@section('content')

<div style="max-width: 440px; margin: 40px auto;">
    <div class="box">
        <div style="text-align: center; margin-bottom: 24px;">
            <span class="logo" style="font-size: 28px; justify-content: center;">Atila<b>Shop</b></span>
            <h2 style="font-size: 20px; font-weight: 800; margin: 12px 0 4px;">ورود به حساب کاربری</h2>
            <p class="muted" style="font-size: 13px; margin: 0;">برای پیگیری سفارش‌ها و تسویه‌حساب وارد شوید</p>
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

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">ایمیل</label>
                <input type="email" name="email" id="login-email" value="{{ old('email') }}" required autofocus dir="ltr" placeholder="example@mail.com">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">رمز عبور</label>
                <input type="password" name="password" id="login-password" required dir="ltr" placeholder="••••••••">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; font-size: 13px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: auto;">
                    <span>مرا به خاطر بسپار</span>
                </label>
            </div>

            <button type="submit" class="btn" style="width: 100%; justify-content: center; font-size: 15px;">
                ورود به حساب
            </button>
        </form>

        <!-- Quick Demo Credentials for Fast Testing -->
        <div style="margin-top: 24px; padding-top: 18px; border-top: 1px dashed var(--line); font-size: 12px;">
            <b class="muted" style="display: block; margin-bottom: 8px;">اکانت‌های تست آماده (کلیک برای پر کردن خودکار):</b>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button type="button" class="btn o" style="padding: 6px 12px; font-size: 12px;" onclick="fillDemo('admin@atilashop.ir', 'admin123456')">
                    👑 مدیر (ادمین)
                </button>
                <button type="button" class="btn o" style="padding: 6px 12px; font-size: 12px;" onclick="fillDemo('sara@example.com', '123456')">
                    🛍️ مشتری (سارا راد)
                </button>
            </div>
        </div>

        <div style="text-align: center; margin-top: 22px; font-size: 13px;" class="muted">
            حساب کاربری ندارید؟ 
            <a href="{{ route('register') }}" style="color: var(--brand); font-weight: 700;">ثبت‌نام کنید</a>
        </div>
    </div>
</div>

<script>
    function fillDemo(email, pass) {
        document.getElementById('login-email').value = email;
        document.getElementById('login-password').value = pass;
    }
</script>

@endsection
