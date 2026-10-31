@extends('layouts.app')

@section('title', 'علاقه‌مندی‌های من | AtilaShop')

@section('content')

<div style="margin: 20px 0 28px;">
    <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 6px;">لیست علاقه‌مندی‌ها</h1>
    <p class="muted" style="margin: 0;">کالاهایی که نشان کرده‌اید تا بعداً راحت‌تر آنها را پیدا و خریداری کنید.</p>
</div>

@if($products->count() > 0)
    <div id="grid-container">
        @include('partials.product_grid', ['products' => $products, 'userWishlist' => $userWishlist])
    </div>
@else
    <div class="box" style="text-align: center; padding: 60px 20px;">
        <svg class="ic" style="width: 56px; height: 56px; color: var(--brand); stroke-width: 1.2; margin-bottom: 16px;"><use href="#i-heart"/></svg>
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">لیست علاقه‌مندی‌های شما خالی است</h3>
        <p class="muted" style="max-width: 380px; margin: 0 auto 20px;">
            با کلیک روی آیکون قلب روی هر محصول، می‌توانید آن را به این لیست اضافه کنید.
        </p>
        <a href="{{ route('home') }}" class="btn">مشاهده محصولات فروشگاه</a>
    </div>
@endif

@endsection
