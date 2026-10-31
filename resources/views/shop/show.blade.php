@extends('layouts.app')

@section('title', $product->name . ' | AtilaShop')

@section('content')
@php
    $hues = $product->hues ?? [345, 28, 205];
    $initialHue = $hues[0] ?? 345;
    $isWished = in_array($product->id, $userWishlist ?? []);
    $defaultSize = (!empty($product->sizes) && count($product->sizes) > 0) ? $product->sizes[0] : 'فری';
@endphp

<div style="margin: 16px 0 24px;">
    <a href="{{ route('home') }}" class="muted" style="font-size: 13px;">فروشگاه</a>
    <span class="muted" style="font-size: 13px; margin: 0 6px;">›</span>
    <a href="{{ route('home', ['c' => $product->category]) }}" class="muted" style="font-size: 13px;">{{ $product->category }}</a>
    <span class="muted" style="font-size: 13px; margin: 0 6px;">›</span>
    <span style="font-size: 13px; font-weight: 600;">{{ $product->name }}</span>
</div>

<div class="box" style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 32px; padding: 28px;">
    <!-- Gallery & Zoom Area -->
    <div>
        <div class="zoom" id="page-zoom" style="--h: {{ $initialHue }}; aspect-ratio: 3/4; display: grid; place-items: center; border-radius: 20px; overflow: hidden; background: hsl(var(--h) 45% var(--bgl, 93%));">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="page-zoom-media" style="width: 100%; height: 100%; object-fit: cover; transition: transform .2s ease;">
            @else
                <svg class="g" id="page-zoom-media" viewBox="0 0 100 130" style="width: 65%;"><use href="#{{ $product->icon ?? 'tee' }}"/></svg>
            @endif
        </div>

        @if(count($hues) > 1)
            <div class="th" style="margin-top: 14px;">
                @foreach($hues as $idx => $hue)
                    <button class="{{ $idx === 0 ? 'on' : '' }}" onclick="selectPageColor({{ $idx }}, {{ $hue }}, this)">
                        <div class="art" style="--h: {{ $hue }}; aspect-ratio: 1/1; border-radius: 12px;">
                            <svg class="g" viewBox="0 0 100 130" style="width: 55%; filter: none;"><use href="#{{ $product->icon ?? 'tee' }}"/></svg>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Product Info Area -->
    <div>
        <div class="muted" style="font-size: 14px;">
            {{ $product->gender === 'w' ? 'لباس زیر زنانه' : 'لباس زیر مردانه' }} › {{ $product->category }}
        </div>
        <h1 style="margin: 8px 0 12px; font-size: 28px; font-weight: 800;">{{ $product->name }}</h1>

        <div style="font-size: 24px; font-weight: 800; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
            <span>{{ $product->formatted_price }}</span>
            @if($product->formatted_original_price)
                <s class="muted" style="font-size: 16px;">{{ $product->formatted_original_price }}</s>
            @endif
            @if($product->discount_percent > 0)
                <b class="b2" style="font-size: 13px; padding: 3px 12px; border-radius: 99px;">
                    {{ number_format($product->discount_percent) }}٪ تخفیف
                </b>
            @endif
        </div>

        @if($product->stock <= 0)
            <div class="low" style="color: var(--muted); margin-bottom: 14px; font-size: 14px;">این محصول متأسفانه در حال حاضر ناموجود است.</div>
        @elseif($product->stock < 6)
            <div class="low" style="margin-bottom: 14px; font-size: 14px;">فقط {{ $product->stock }} عدد در انبار باقی مانده!</div>
        @endif

        <p class="muted" style="font-size: 15px; line-height: 1.8; margin-bottom: 20px;">
            {{ $product->description ?: 'دوخت باکیفیت و ظریف؛ استفاده از الیاف لطیف و فاق دولایه ۱۰۰٪ پنبه‌ای ضدحساسیت و ضدتعریق.' }}
        </p>

        @if(count($hues) > 1)
            <b style="font-size: 14px; display: block; margin-top: 14px;">انتخاب رنگ:</b>
            <div class="sw" style="margin: 8px 0 16px;" id="page-color-swatches">
                @foreach($hues as $idx => $hue)
                    <button class="dot {{ $idx === 0 ? 'on' : '' }}" 
                            style="--h: {{ $hue }}; width: 26px; height: 26px;" 
                            onclick="selectPageColor({{ $idx }}, {{ $hue }})" 
                            aria-label="رنگ {{ $idx + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif

        @if(!empty($product->sizes))
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; margin-bottom: 6px;">
                <b style="font-size: 14px;">انتخاب سایز:</b>
                <button type="button" onclick="openSizeGuide('{{ $product->gender === 'm' ? 'men' : ($product->category === 'سوتین' || $product->category === 'ست لباس زیر' ? 'bra' : 'panty') }}')" style="font-size: 13px; color: var(--brand); font-weight: 700; text-decoration: underline; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                    <svg class="ic" style="width: 16px; height: 16px;"><use href="#i-ruler"/></svg>
                    <span>راهنمای تخصصی سایز</span>
                </button>
            </div>
            <div class="sz" id="page-size-selector">
                @foreach($product->sizes as $idx => $sz)
                    <button type="button" class="{{ $idx === 0 ? 'on' : '' }}" onclick="selectPageSize('{{ $sz }}', this)">
                        {{ $sz }}
                    </button>
                @endforeach
            </div>
        @endif

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button class="btn brand" style="flex: 1; justify-content: center; font-size: 16px;" 
                    {{ $product->stock <= 0 ? 'disabled style="opacity:.5; cursor:not-allowed;"' : '' }}
                    onclick="addToCart({{ $product->id }}, selectedPageSize, selectedPageColorIndex)">
                افزودن به سبد خرید
            </button>
            <button class="ib" style="border: 1px solid var(--line); width: 50px; height: 50px; border-radius: 16px;" 
                    onclick="toggleWishlist({{ $product->id }}, this)">
                <svg class="ic" style="{{ $isWished ? 'fill: var(--brand); stroke: var(--brand);' : '' }}"><use href="#i-heart"/></svg>
            </button>
        </div>

        <ul class="ft" style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--line);">
            <li><svg class="ic" style="color: var(--brand);"><use href="#i-box-lock"/></svg> <b>بسته‌بندی ۱۰۰٪ محرمانه:</b> ارسال در کارتن مات بدون درج نام کالا یا لوگو</li>
            <li><svg class="ic" style="color: var(--brand);"><use href="#i-shield"/></svg> <b>پلمپ بهداشتی اختصاصی:</b> تضمین سلامت و آکبند بودن کامل مرسوله</li>
            <li><svg class="ic" style="color: var(--brand);"><use href="#i-feather"/></svg> <b>فاق پنبه‌ای ضدحساسیت:</b> الیاف طبیعی سازگار با پوست حساس</li>
            <li><svg class="ic" style="color: var(--brand);"><use href="#i-truck"/></svg> ارسال سریع؛ رایگان برای سفارش‌های بالای ۲ میلیون تومان</li>
        </ul>
    </div>
</div>

<!-- Recommended Outfits ("ست پیشنهادی") -->
@if(isset($related) && count($related) > 0)
    <h2 class="t" style="margin-top: 48px;">محصولات مکمل پیشنهادی</h2>
    <div class="grid">
        @foreach($related as $rel)
            @include('partials.product_card', ['product' => $rel, 'userWishlist' => $userWishlist])
        @endforeach
    </div>
@endif

@endsection

@section('scripts')
<script>
    let selectedPageColorIndex = 0;
    let selectedPageSize = '{{ $defaultSize }}';

    function selectPageColor(idx, hue, btnElem = null) {
        selectedPageColorIndex = idx;
        const zoomBox = $('#page-zoom');
        if (zoomBox) {
            zoomBox.style.setProperty('--h', hue);
        }
        $$('.th button').forEach((b, i) => b.classList.toggle('on', i === idx));
        $$('#page-color-swatches .dot').forEach((d, i) => d.classList.toggle('on', i === idx));
    }

    function selectPageSize(size, btnElem) {
        selectedPageSize = size;
        $$('#page-size-selector button').forEach(b => b.classList.remove('on'));
        btnElem.classList.add('on');
    }

    // Zoom on hover
    const zoomBox = $('#page-zoom');
    const zoomMedia = $('#page-zoom-media');
    if (zoomBox && zoomMedia) {
        zoomBox.addEventListener('mousemove', (e) => {
            const rect = zoomBox.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            zoomMedia.style.transformOrigin = `${x}% ${y}%`;
            zoomMedia.style.transform = 'scale(2.1)';
        });
        zoomBox.addEventListener('mouseleave', () => {
            zoomMedia.style.transform = 'none';
        });
    }
</script>
@endsection
