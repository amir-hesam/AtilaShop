@php
    $hues = $product->hues ?? [345, 28, 205];
    $initialHue = $hues[0] ?? 345;
    $isWished = in_array($product->id, $userWishlist ?? []);
@endphp

<article class="card" id="card-{{ $product->id }}">
    <div class="im" onclick="openProductModal({{ $product->id }})" id="im-{{ $product->id }}" style="--h: {{ $initialHue }};">
        @if($product->image_url)
            <div class="art" style="aspect-ratio: 3/4; overflow: hidden; background: var(--card-media-bg);">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease;" class="card-photo">
            </div>
        @else
            <div class="art" style="--h: {{ $initialHue }};">
                <svg class="g" viewBox="0 0 100 130"><use href="#{{ $product->icon ?? 'tee' }}"/></svg>
            </div>
        @endif

        <div class="bd">
            @if($product->tag)
                <b class="b1">{{ $product->tag }}</b>
            @endif
            @if($product->discount_percent > 0)
                <b class="b2">{{ number_format($product->discount_percent) }}٪ تخفیف</b>
            @endif
        </div>

        <button class="hb {{ $isWished ? 'on' : '' }}" 
                data-id="{{ $product->id }}" 
                onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)" 
                aria-label="علاقه‌مندی">
            <svg class="ic"><use href="#i-heart"/></svg>
        </button>

        @if($product->stock > 0 && !empty($product->sizes))
            <div class="qa" onclick="event.stopPropagation()">
                <span style="font-size: 11px; margin-inline-end: 2px;">افزودن:</span>
                @foreach($product->sizes as $sz)
                    <button type="button" onclick="addToCart({{ $product->id }}, '{{ $sz }}', 0)">{{ $sz }}</button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="inf">
        @if(count($hues) > 1)
            <div class="sw">
                @foreach($hues as $idx => $hue)
                    <button class="dot {{ $idx === 0 ? 'on' : '' }}" 
                            style="--h: {{ $hue }}" 
                            onclick="event.stopPropagation(); changeCardColor({{ $product->id }}, {{ $hue }}, this, {{ $idx }})" 
                            aria-label="رنگ {{ $idx + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif

        <a href="{{ route('products.show', $product->id) }}" class="nm">
            {{ $product->name }}
        </a>

        <div class="pr">
            <span>{{ $product->formatted_price }}</span>
            @if($product->formatted_original_price)
                <s>{{ $product->formatted_original_price }}</s>
            @endif
        </div>

        @if($product->stock <= 0)
            <div class="low" style="color: var(--muted);">ناموجود</div>
        @elseif($product->stock < 6)
            <div class="low">فقط {{ $product->stock }} عدد باقی مانده!</div>
        @endif
    </div>
</article>
