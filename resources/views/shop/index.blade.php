@extends('layouts.app')

@section('title', 'AtilaShop | بوتیک تخصصی لباس زیر زنانه و مردانه')

@section('content')

    <!-- Hero Banner Slider -->
    <section class="hero" id="hero">
        <!-- Slide 1: Lingerie Sets -->
        <div class="sl on" style="--h: 345;">
            <div>
                <span class="kick">کالکشن اختصاصی لباس زیر زنانه</span>
                <h1>ظرافت دانتل و گیپور، زیبایی بی‌همتا</h1>
                <p>ست‌های شورت و سوتین فنردار و اسفنجی با کاپ استاندارد، خوش‌فرم و با لطافت ابریشمی برای بانوان خاص‌پسند.</p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('home', ['c' => 'ست لباس زیر']) }}" class="btn">
                        مشاهده ست‌های لباس زیر
                    </a>
                    <button type="button" onclick="openSizeGuide('bra')" class="btn o" style="border-color: currentColor;">
                        📐 راهنمای آنلاین سایز
                    </button>
                </div>
            </div>
            <div class="arch" style="padding: 0; overflow: hidden;">
                <img src="/storage/products/set_lingerie.jpg" alt="ست لباس زیر دانتل مجلسی" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="tag">دانتل ترک درجه ۱</span>
            </div>
        </div>

        <!-- Slide 2: Organic Cotton & Seamless Everyday -->
        <div class="sl" style="--h: 335;">
            <div>
                <span class="kick">راحتی و سلامت روزمره</span>
                <h1>نخ‌پنبه ارگانیک و الیاف ضدحساسیت</h1>
                <p>سوتین‌های نخی خنک و شورت‌های لیزری بدون خط دوخت با فاق دولایه پنبه‌ای مناسب استفاده تمام‌روز.</p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('home', ['c' => 'شورت زنانه']) }}" class="btn">
                        خرید شورت نخی و لیزری
                    </a>
                    <a href="{{ route('home', ['c' => 'سوتین']) }}" class="btn o" style="border-color: currentColor;">
                        سوتین‌های راحتی
                    </a>
                </div>
            </div>
            <div class="arch" style="padding: 0; overflow: hidden;">
                <img src="/storage/products/panty_pink.jpg" alt="شورت نخی زنانه" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="tag">فاق پنبه‌ای ارگانیک</span>
            </div>
        </div>

        <!-- Slide 3: Men's Underwear -->
        <div class="sl" style="--h: 215;">
            <div>
                <span class="kick">کالکشن لباس زیر مردانه</span>
                <h1>راحتی سوپرپنبه و الیاف گیاهی مودال</h1>
                <p>شورت‌های پادار و اسلیپ مردانه با کش نرم بدون ایجاد رد و خط روی پوست، ضد تعریق و بسیار خنک.</p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('home', ['c' => 'لباس زیر مردانه']) }}" class="btn">
                        کالکشن مردانه (باکسر و اسلیپ)
                    </a>
                </div>
            </div>
            <div class="arch" style="padding: 0; overflow: hidden;">
                <img src="/storage/products/boxer_men.jpg" alt="شورت پادار مردانه" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="tag">پک اقتصادی ضدتعریق</span>
            </div>
        </div>

        <!-- Pagination Bars -->
        <div class="pg" id="hero-pg">
            <i class="on" onclick="heroGo(0)"></i>
            <i onclick="heroGo(1)"></i>
            <i onclick="heroGo(2)"></i>
        </div>
    </section>

    <!-- Trust Badges for Lingerie -->
    <div class="trust">
        <div>
            <svg class="ic"><use href="#i-box-lock"/></svg>
            <span><b>بسته‌بندی ۱۰۰٪ محرمانه</b>ارسال در کارتن مات بدون درج نام کالا یا لوگو</span>
        </div>
        <div>
            <svg class="ic"><use href="#i-shield"/></svg>
            <span><b>پلمپ بهداشتی اختصاصی</b>تضمین آکبند و استریل بودن کامل کالا</span>
        </div>
        <div>
            <svg class="ic"><use href="#i-ruler"/></svg>
            <span><b>راهنمای دقیق انتخاب سایز</b>جدول کاپ و دور سینه با ماشین‌حساب هوشمند</span>
        </div>
        <div>
            <svg class="ic"><use href="#i-feather"/></svg>
            <span><b>فاق نخ‌پنبه ضدحساسیت</b>الیاف طبیعی، تنفس‌پذیر و مراقب سلامت پوست</span>
        </div>
    </div>

    <!-- Category Tiles -->
    <h2 class="t">دسته‌بندی‌های تخصصی لباس زیر</h2>
    <div class="tiles" style="grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));">
        <a href="{{ route('home', ['c' => 'ست لباس زیر']) }}" class="tile">
            <div class="art" style="aspect-ratio: 1/1; overflow: hidden; border-radius: 18px;">
                <img src="/storage/products/set_lingerie.jpg" alt="ست لباس زیر" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s;">
            </div>
            <span style="font-weight: 700; margin-top: 8px;">ست شورت و سوتین</span>
        </a>
        <a href="{{ route('home', ['c' => 'سوتین']) }}" class="tile">
            <div class="art" style="aspect-ratio: 1/1; overflow: hidden; border-radius: 18px;">
                <img src="/storage/products/bra_lace.jpg" alt="سوتین و نیم‌تنه" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s;">
            </div>
            <span style="font-weight: 700; margin-top: 8px;">سوتین و نیم‌تنه</span>
        </a>
        <a href="{{ route('home', ['c' => 'شورت زنانه']) }}" class="tile">
            <div class="art" style="aspect-ratio: 1/1; overflow: hidden; border-radius: 18px;">
                <img src="/storage/products/panty_pink.jpg" alt="شورت زنانه" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s;">
            </div>
            <span style="font-weight: 700; margin-top: 8px;">شورت زنانه (نخی و لیزری)</span>
        </a>
        <a href="{{ route('home', ['c' => 'بادی']) }}" class="tile">
            <div class="art" style="aspect-ratio: 1/1; overflow: hidden; border-radius: 18px;">
                <img src="/storage/products/bodysuit.jpg" alt="بادی مجلسی" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s;">
            </div>
            <span style="font-weight: 700; margin-top: 8px;">بادی مجلسی و فانتزی</span>
        </a>
        <a href="{{ route('home', ['c' => 'لباس زیر مردانه']) }}" class="tile">
            <div class="art" style="aspect-ratio: 1/1; overflow: hidden; border-radius: 18px;">
                <img src="/storage/products/boxer_men.jpg" alt="لباس زیر مردانه" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s;">
            </div>
            <span style="font-weight: 700; margin-top: 8px;">لباس زیر مردانه</span>
        </a>
    </div>

    <!-- Discreet Packaging Reassurance Banner -->
    <div style="background: linear-gradient(135deg, #ffffff 0%, var(--brand-light) 100%); border: 1px solid var(--brand-border); border-radius: 22px; padding: 22px 26px; margin: 28px 0 34px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; box-shadow: 0 6px 22px rgba(168, 43, 89, 0.06);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 52px; height: 52px; border-radius: 16px; background: var(--brand-light); border: 1px solid var(--brand-border); display: grid; place-items: center; color: var(--brand); flex-shrink: 0; box-shadow: 0 4px 12px rgba(168, 43, 89, 0.12);">
                <svg class="ic" style="width: 28px; height: 28px;"><use href="#i-box-lock"/></svg>
            </div>
            <div>
                <b style="font-size: 16px; display: block; margin-bottom: 4px; color: var(--ink);">خیال شما آسوده؛ تضمین ۱۰۰٪ بسته‌بندی محرمانه</b>
                <p class="muted" style="margin: 0; font-size: 13px; line-height: 1.7;">
                    بسته‌های سفارش شما در کارتن‌های پستی کاملاً پوشیده، مات و بدون هرگونه نام محصول، لوگوی لباس زیر یا تصویر ارسال می‌گردد تا حریم خصوصی شما حفظ شود.
                </p>
            </div>
        </div>
        <button type="button" onclick="openSizeGuide()" class="btn o" style="font-size: 13px; padding: 10px 22px;">
            📐 جدول انتخاب سایز
        </button>
    </div>

    <!-- Catalog Section with Filters -->
    <h2 class="t" id="shop">
        پرفروش‌ها و تازه‌ها 
        <small id="product-count-label">({{ number_format($products->total()) }} کالا)</small>
    </h2>

    <form method="GET" action="{{ route('home') }}" id="filter-form">
        <div class="tool">
            <!-- Chips -->
            <div class="chips">
                <a href="{{ route('home') }}" class="chip {{ !request('c') && !request('g') && !request('x') && !request('w') ? 'on' : '' }}">
                    همه
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', array_merge(request()->except('c', 'page'), ['c' => $cat])) }}" 
                       class="chip {{ request('c') === $cat ? 'on' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
                @auth
                    <a href="{{ route('home', array_merge(request()->except('w', 'page'), ['w' => request('w') ? null : 1])) }}" 
                       class="chip {{ request('w') ? 'on' : '' }}">
                        فقط علاقه‌مندی‌ها
                    </a>
                @endauth
            </div>

            <!-- Search Input -->
            <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="جستجوی نام لباس...">

            <!-- Price Filter Dropdown -->
            <select name="pr" id="pr-select" onchange="this.form.submit()">
                <option value="">همه‌ی قیمت‌ها</option>
                <option value="0-500000" {{ request('pr') === '0-500000' ? 'selected' : '' }}>تا ۵۰۰ هزار تومان</option>
                <option value="500000-1000000" {{ request('pr') === '500000-1000000' ? 'selected' : '' }}>۵۰۰ هزار تا ۱ میلیون</option>
                <option value="1000000-" {{ request('pr') === '1000000-' ? 'selected' : '' }}>بالای ۱ میلیون تومان</option>
            </select>

            <!-- Sort Dropdown -->
            <select name="s" id="s-select" onchange="this.form.submit()">
                <option value="" {{ !request('s') ? 'selected' : '' }}>جدیدترین</option>
                <option value="cheap" {{ request('s') === 'cheap' ? 'selected' : '' }}>ارزان‌ترین</option>
                <option value="exp" {{ request('s') === 'exp' ? 'selected' : '' }}>گران‌ترین</option>
            </select>

            <!-- Hidden filters persistence -->
            @if(request('c')) <input type="hidden" name="c" value="{{ request('c') }}"> @endif
            @if(request('g')) <input type="hidden" name="g" value="{{ request('g') }}"> @endif
            @if(request('x')) <input type="hidden" name="x" value="{{ request('x') }}"> @endif
            @if(request('w')) <input type="hidden" name="w" value="{{ request('w') }}"> @endif
        </div>
    </form>

    <!-- Product Grid -->
    <div id="grid-container">
        @include('partials.product_grid', ['products' => $products, 'userWishlist' => $userWishlist])
    </div>

    <!-- Promo Banner -->
    <section class="promo">
        <div>
            <h3>حراج هفتگی لباس زیر زنانه و مردانه<br>تا ۳۰٪ تخفیف ویژه</h3>
            <p>روی ست‌های دانتل ترک، سوتین‌های اسفنجی و پک‌های اقتصادی شورت نخی؛ به مدت محدود تا پایان هفته.</p>
        </div>
        <a href="{{ route('home', ['x' => 'sale']) }}" class="btn">
            دیدن ست‌ها و کالاهای حراج
        </a>
    </section>

    <!-- Newsletter -->
    <div class="nl">
        <div style="display: block;">
            <b style="font-size: 16px;">از تخفیف‌ها و کالکشن‌های جدید لباس زیر زودتر باخبر شوید</b>
            <div class="muted" style="font-size: 13px; margin-top: 4px;">ایمیل‌تان را وارد کنید؛ حداکثر هفته‌ای یک پیام اطلاع‌رسانی ارسال می‌شود.</div>
        </div>
        <div>
            <input type="email" placeholder="ایمیل شما (مثال: sara@gmail.com)" dir="ltr">
            <button class="btn" type="button" onclick="toast('عضویت در خبرنامه با موفقیت ثبت شد.')">عضویت</button>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Hero Slider Auto-rotation
    let currentSlide = 0;
    const slides = $$('.sl');
    const heroIndicators = $$('#hero-pg i');
    let heroTimer = null;

    function heroGo(index) {
        currentSlide = (index + slides.length) % slides.length;
        slides.forEach((sl, i) => sl.classList.toggle('on', i === currentSlide));
        heroIndicators.forEach((ind, i) => {
            ind.classList.remove('on');
            if (i === currentSlide) {
                void ind.offsetWidth; // Force reflow to restart fill animation
                ind.classList.add('on');
            }
        });
        clearInterval(heroTimer);
        heroTimer = setInterval(() => heroGo(currentSlide + 1), 5000);
    }
    heroTimer = setInterval(() => heroGo(currentSlide + 1), 5000);

    // Card Color Variant Switcher
    function changeCardColor(productId, hue, dotElem, colorIndex) {
        const cardIm = $(`#im-${productId}`);
        if (cardIm) {
            cardIm.style.setProperty('--h', hue);
            const art = cardIm.querySelector('.art');
            if (art) art.style.setProperty('--h', hue);
        }
        const sw = dotElem.closest('.sw');
        if (sw) {
            sw.querySelectorAll('.dot').forEach(d => d.classList.remove('on'));
            dotElem.classList.add('on');
        }
    }

    // Modal Quick View Logic
    const productsData = @json($products->items());
    let modalActiveProduct = null;
    let modalSelectedColorIndex = 0;
    let modalSelectedSize = '';

    function openProductModal(productId) {
        const p = productsData.find(x => x.id === productId);
        if (!p) {
            window.location.href = `/products/${productId}`;
            return;
        }

        modalActiveProduct = p;
        modalSelectedColorIndex = 0;
        modalSelectedSize = (p.sizes && p.sizes.length > 0) ? p.sizes[0] : 'فری';

        renderProductModal();
        modalOverlay.classList.add('on');
        $('#modal-content').scrollTop = 0;
    }

    function renderProductModal() {
        const p = modalActiveProduct;
        const hues = p.hues || [345];
        const currentHue = hues[modalSelectedColorIndex] || 345;
        const isWished = @json($userWishlist).includes(p.id);

        $('#modal-content').innerHTML = `
            <button class="x" onclick="closeModal()" aria-label="بستن">${ic('x')}</button>
            <div>
                <div class="zoom" id="modal-zoom" style="--h: ${currentHue}; aspect-ratio: 3/4; display: grid; place-items: center; border-radius: 20px; overflow: hidden;">
                    ${p.image ? `
                        <img src="/storage/${p.image}" alt="${p.name}" id="modal-zoom-media" style="width: 100%; height: 100%; object-fit: cover; transition: transform .2s ease;">
                    ` : `
                        <svg class="g" id="modal-zoom-media" viewBox="0 0 100 130" style="width: 65%;"><use href="#${p.icon || 'tee'}"/></svg>
                    `}
                </div>
                <div class="th">
                    ${hues.map((h, i) => `
                        <button class="${i === modalSelectedColorIndex ? 'on' : ''}" onclick="selectModalColor(${i})">
                            <div class="art" style="--h: ${h}; aspect-ratio: 1/1; border-radius: 10px;">
                                <svg class="g" viewBox="0 0 100 130" style="width: 55%; filter: none;"><use href="#${p.icon || 'tee'}"/></svg>
                            </div>
                        </button>
                    `).join('')}
                </div>
            </div>
            <div>
                <div class="muted" style="font-size: 13px;">
                    ${p.gender === 'w' ? 'لباس زیر زنانه' : 'لباس زیر مردانه'} › ${p.category}
                </div>
                <h2 style="margin: 4px 0 8px; font-size: 24px; font-weight: 800;">${p.name}</h2>
                <div style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">
                    ${fmt(p.price)}
                    ${p.original_price ? `<s class="muted" style="font-size: 14px; margin-inline-start: 6px;">${fmt(p.original_price)}</s>` : ''}
                    ${p.discount_percent ? `<b class="b2" style="font-size: 12px; padding: 2px 10px; border-radius: 99px; margin-inline-start: 8px;">${fa(p.discount_percent)}٪ تخفیف</b>` : ''}
                </div>

                ${p.stock <= 0 ? '<div class="low" style="color: var(--muted); margin-bottom: 12px;">متأسفانه این محصول در حال حاضر ناموجود است.</div>' : ''}
                ${p.stock > 0 && p.stock < 6 ? `<div class="low" style="margin-bottom: 12px;">فقط ${fa(p.stock)} عدد در انبار باقی مانده!</div>` : ''}

                <p class="muted" style="font-size: 14px; line-height: 1.8;">
                    ${p.description || 'پارچه لطیف و دوخت باکیفیت؛ فاق دولایه ضدحساسیت و سازگار با پوست.'}
                </p>

                ${hues.length > 1 ? `
                    <b style="font-size: 14px; display: block; margin-top: 14px;">رنگ‌بندی:</b>
                    <div class="sw" style="margin: 6px 0 14px;">
                        ${hues.map((h, i) => `
                            <button class="dot ${i === modalSelectedColorIndex ? 'on' : ''}" 
                                    style="--h: ${h}; width: 24px; height: 24px;" 
                                    onclick="selectModalColor(${i})" 
                                    aria-label="رنگ ${fa(i + 1)}"></button>
                        `).join('')}
                    </div>
                ` : ''}

                ${p.sizes && p.sizes.length > 0 ? `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; margin-bottom: 4px;">
                        <b style="font-size: 14px;">انتخاب سایز:</b>
                        <button type="button" onclick="openSizeGuide('${p.gender === 'm' ? 'men' : (p.category === 'سوتین' || p.category === 'ست لباس زیر' ? 'bra' : 'panty')}')" style="font-size: 12px; color: var(--brand); font-weight: 700; text-decoration: underline; cursor: pointer;">
                            📐 راهنمای انتخاب سایز
                        </button>
                    </div>
                    <div class="sz">
                        ${p.sizes.map(z => `
                            <button class="${z === modalSelectedSize ? 'on' : ''}" onclick="selectModalSize('${z}', this)">${z}</button>
                        `).join('')}
                    </div>
                ` : ''}

                <div style="display: flex; gap: 10px; margin-top: 18px;">
                    <button class="btn brand" style="flex: 1; justify-content: center;" 
                            ${p.stock <= 0 ? 'disabled style="opacity: .5; cursor: not-allowed;"' : ''}
                            onclick="addToCart(${p.id}, '${modalSelectedSize}', ${modalSelectedColorIndex})">
                        افزودن به سبد خرید
                    </button>
                    <button class="ib" style="border: 1px solid var(--line); width: 48px; height: 48px; border-radius: 14px;" 
                            onclick="toggleWishlist(${p.id}, this)">
                        <svg class="ic" style="${isWished ? 'fill: var(--brand); stroke: var(--brand);' : ''}"><use href="#i-heart"/></svg>
                    </button>
                </div>

                <ul class="ft">
                    <li>${ic('box-lock')} بسته‌بندی ۱۰۰٪ محرمانه در کارتن ساده بدون درج نام کالا</li>
                    <li>${ic('shield')} پلمپ بهداشتی اختصاصی و تضمین اصالت و سلامت فردی</li>
                    <li>${ic('feather')} الیاف نرم، فاق دولایه ضدحساسیت و تنفس‌پذیر</li>
                </ul>
            </div>
        `;

        setupModalZoom();
    }

    function selectModalColor(index) {
        modalSelectedColorIndex = index;
        renderProductModal();
    }

    function selectModalSize(size, btnElem) {
        modalSelectedSize = size;
        $$('.sz button').forEach(b => b.classList.remove('on'));
        btnElem.classList.add('on');
    }

    // Interactive Mouse Hover Zoom (FR-39)
    function setupModalZoom() {
        const zoomBox = $('#modal-zoom');
        if (!zoomBox) return;
        const zoomMedia = $('#modal-zoom-media');
        if (!zoomMedia) return;

        zoomBox.addEventListener('mousemove', (e) => {
            const rect = zoomBox.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            zoomMedia.style.transformOrigin = `${x}% ${y}%`;
            zoomMedia.style.transform = 'scale(2)';
        });

        zoomBox.addEventListener('mouseleave', () => {
            zoomMedia.style.transform = 'none';
        });
    }

    // Auto submit search on input stop
    let searchTimeout = null;
    $('#q')?.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            $('#filter-form').submit();
        }, 700);
    });
</script>
@endsection
