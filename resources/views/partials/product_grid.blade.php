<div class="grid">
    @forelse($products as $product)
        @include('partials.product_card', ['product' => $product, 'userWishlist' => $userWishlist])
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0;" class="muted">
            <svg class="ic" style="width: 48px; height: 48px; stroke-width: 1.2; margin-bottom: 12px;"><use href="#i-search"/></svg>
            <p style="font-size: 16px;">هیچ محصولی با این مشخصات یافت نشد.</p>
            <a href="{{ route('home') }}" class="btn o" style="margin-top: 10px; font-size: 13px;">مشاهده همه محصولات</a>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div style="margin-top: 36px; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
@endif
