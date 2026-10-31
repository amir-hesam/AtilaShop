@extends('layouts.app')

@section('title', 'ثبت‌نام در AtilaShop')

@section('content')

<div style="max-width: 440px; margin: 40px auto;">
    <div class="box">
        <div style="text-align: center; margin-bottom: 24px;">
            <span class="logo" style="font-size: 28px; justify-content: center;">Atila<b>Shop</b></span>
            <h2 style="font-size: 20px; font-weight: 800; margin: 12px 0 4px;">ایجاد حساب کاربری</h2>
            <p class="muted" style="font-size: 13px; margin: 0;">به خانواده بزرگ آتیلاشاپ بپیوندید</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نام و نام خانوادگی</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="مثلاً: مریم احمدی">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">ایمیل</label>
                <input type="email" name="email" value="{{ old('email') }}" required dir="ltr" placeholder="example@mail.com">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">رمز عبور (حداقل ۶ کاراکتر)</label>
                <input type="password" name="password" required dir="ltr" placeholder="••••••••">
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" required dir="ltr" placeholder="••••••••">
            </div>

            <button type="submit" class="btn" style="width: 100%; justify-content: center; font-size: 15px;">
                ثبت‌نام و عضویت
            </button>
        </form>

        <div style="text-align: center; margin-top: 22px; font-size: 13px;" class="muted">
            قبلاً ثبت‌نام کرده‌اید؟ 
            <a href="{{ route('login') }}" style="color: var(--brand); font-weight: 700;">وارد شوید</a>
        </div>
    </div>
</div>

@endsection
