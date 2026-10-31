@extends('layouts.app')

@section('title', 'جزئیات سفارش ' . $order->order_number . ' | AtilaShop')

@section('content')

<div style="margin: 20px 0 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 24px; font-weight: 800; margin: 0 0 6px;">
            سفارش شماره {{ $order->order_number }}
        </h1>
        <div class="muted" style="font-size: 13px;">
            تاریخ ثبت: {{ $order->created_at->format('Y/m/d H:i') }}
        </div>
    </div>

    <div style="display: flex; gap: 10px; align-items: center;">
        <span style="font-size: 13px; font-weight: 700; padding: 6px 16px; border-radius: 99px; border: 1px solid var(--line); background: var(--bg);">
            وضعیت: {{ $order->status }}
        </span>

        @if($order->status === 'پرداخت ناموفق')
            <a href="{{ route('payment.gateway', $order->id) }}" class="btn brand" style="padding: 8px 18px; font-size: 13px;">
                تلاش مجدد برای پرداخت
            </a>
        @endif

        @if($order->status === 'در انتظار پرداخت' && $order->payment_method === 'card_transfer')
            <a href="{{ route('orders.card_transfer', $order->id) }}" class="btn brand" style="padding: 8px 18px; font-size: 13px;">
                ثبت تصویر و کد پیگیری فیش
            </a>
        @endif
    </div>
</div>

<!-- Order Progress Stepper (Digikala 5-Steps) -->
<div class="box" style="margin-bottom: 24px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--line); padding-bottom: 12px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <svg class="ic" style="color: var(--brand); width: 22px; height: 22px;"><use href="#i-truck"/></svg>
            <b style="font-size: 16px;">پیگیری مرحله‌به‌مرحله سفارش (وضعیت ارسال)</b>
        </div>
        <span class="badge-status {{ $order->status_badge_class }}">
            {{ $order->status }}
        </span>
    </div>

    @if($order->isCancelled())
        <div class="alert alert-error" style="margin: 16px 0;">
            <svg class="ic"><use href="#i-x"/></svg>
            <span><b>سفارش لغو شده است:</b> واریز یا فیش این سفارش تأیید نگردید یا سفارش توسط کاربر لغو شده است.</span>
        </div>
    @else
        @php
            $currStep = $order->step_index;
            $steps = [
                1 => ['title' => 'ثبت سفارش', 'sub' => 'ثبت اولیه', 'icon' => 'i-orders'],
                2 => ['title' => 'تأیید پرداخت', 'sub' => ($order->status === 'در انتظار تأیید پرداخت' ? 'در صف بررسی فیش' : ($currStep >= 2 ? 'پرداخت تأیید شد' : 'در انتظار واریز')), 'icon' => 'i-shield'],
                3 => ['title' => 'بسته‌بندی محرمانه', 'sub' => ($currStep > 3 ? 'بسته‌بندی شد' : ($currStep === 3 ? 'در حال پلمپ بهداشتی' : 'در صف بسته‌بندی')), 'icon' => 'i-box-lock'],
                4 => ['title' => 'تحویل به پست/ارسال', 'sub' => ($currStep >= 4 ? 'تحویل پست گردید' : 'آماده‌سازی برای ارسال'), 'icon' => 'i-truck'],
                5 => ['title' => 'تحویل مرسوله', 'sub' => ($currStep === 5 ? 'تحویل داده شد' : 'تحویل به خریدار'), 'icon' => 'i-check'],
            ];
        @endphp

        <div class="order-stepper">
            @foreach($steps as $idx => $step)
                @php
                    $isCompleted = ($currStep > $idx) || ($currStep === 5);
                    $isActive = ($currStep === $idx) && ($currStep !== 5);
                @endphp
                <div class="step-item {{ $isCompleted ? 'completed' : ($isActive ? 'active' : 'pending') }}">
                    <div class="step-connector"></div>
                    <div class="step-node">
                        @if($isCompleted)
                            <svg class="ic" style="width: 18px; height: 18px;"><use href="#i-check"/></svg>
                        @else
                            <span>{{ $idx }}</span>
                        @endif
                    </div>
                    <div class="step-label">{{ $step['title'] }}</div>
                    <div class="step-sub">{{ $step['sub'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Current Stage Dynamic Guidance -->
        <div style="background: var(--brand-light); border: 1px solid var(--brand-border); border-radius: 16px; padding: 16px 20px; margin-top: 14px; font-size: 13.5px; line-height: 1.7; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 14px rgba(168, 43, 89, 0.06);">
            @if($order->status === 'در انتظار پرداخت')
                <svg class="ic" style="color: var(--warning); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-orders"/></svg>
                <div>
                    <b>مرحله ۱: در انتظار واریز وجه:</b> لطفاً مبلغ سفارش را به شماره کارت فروشگاه واریز نموده و فیش را ضمیمه کنید تا وارد مرحله بررسی و تأیید پرداخت شود.
                </div>
            @elseif($order->status === 'در انتظار تأیید پرداخت')
                <svg class="ic" style="color: var(--brand); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-shield"/></svg>
                <div>
                    <b>مرحله ۲: فیش پرداخت در صف بررسی مالی:</b> فیش واریزی شما با شماره پیگیری <b>{{ $order->tracking_code }}</b> ثبت گردید و هم‌اکنون توسط واحد مالی در حال مطابقت است. پس از تأیید، سفارش بدون معطلی به انبار جهت بسته‌بندی فرستاده می‌شود.
                </div>
            @elseif($order->status === 'تأیید پرداخت' || $order->status === 'پرداخت شده')
                <svg class="ic" style="color: var(--success); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-check"/></svg>
                <div>
                    <b>مرحله ۲ تکمیل شد:</b> پرداخت سفارش شما تأیید گردید. کالاها به بخش انبار جهت بسته‌بندی ارجاع شدند.
                </div>
            @elseif($order->status === 'در حال آماده‌سازی و بسته‌بندی')
                <svg class="ic" style="color: var(--brand); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-box-lock"/></svg>
                <div>
                    <b>مرحله ۳: در حال آماده‌سازی و بسته‌بندی محرمانه:</b> سفارش شما با پلمپ بهداشتی و در کارتن ضخیم و مات بدون درج نام کالا یا لوگو آماده‌سازی می‌شود.
                </div>
            @elseif($order->status === 'تحویل به پست / ارسال شده')
                <svg class="ic" style="color: var(--success); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-truck"/></svg>
                <div>
                    <b>مرحله ۴: مرسوله تحویل شرکت پست گردید:</b>
                    @if($order->tracking_code)
                        کد رهگیری پستی مرسوله: <b dir="ltr" style="color: var(--brand); font-size: 15px; margin: 0 4px;">{{ $order->tracking_code }}</b>
                    @endif
                    می‌توانید روند جابجایی بسته را از سامانه رهگیری پستی دنبال کنید.
                </div>
            @elseif($order->status === 'تحویل داده شد')
                <svg class="ic" style="color: var(--success); width: 22px; height: 22px; flex-shrink: 0;"><use href="#i-check"/></svg>
                <div>
                    <b>مرحله ۵: مرسوله تحویل داده شد:</b> سفارش با موفقیت به گیرنده تحویل داده شد. از خرید شما از فروشگاه آتیلاشاپ سپاسگزاریم!
                </div>
            @endif
        </div>
    @endif
</div>

<div style="display: grid; grid-template-columns: 1.4fr .8fr; gap: 24px; align-items: start;">
    <!-- Items List -->
    <div class="box">
        <h3 style="font-size: 17px; font-weight: 800; margin: 0 0 16px; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
            اقلام سفارش
        </h3>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            @foreach($order->items as $item)
                @php
                    $prod = $item->product;
                    $hues = $prod ? ($prod->hues ?? [345]) : [345];
                    $hue = $hues[$item->color_index] ?? 345;
                @endphp
                <div style="display: flex; align-items: center; gap: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
                    <div class="art" style="--h: {{ $hue }}; width: 56px; height: 68px; border-radius: 12px; flex: none;">
                        <svg class="g" viewBox="0 0 100 130" style="width: 55%; filter: none;"><use href="#{{ $prod->icon ?? 'tee' }}"/></svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 15px;">{{ $item->product_name }}</div>
                        <div class="muted" style="font-size: 13px; margin-top: 2px;">
                            سایز: <b>{{ $item->size }}</b> · تعداد: <b>{{ $item->quantity }}</b>
                        </div>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; font-size: 15px;">{{ $item->formatted_total_price }}</div>
                        <div class="muted" style="font-size: 12px;">هر عدد: {{ $item->formatted_unit_price }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 18px; font-weight: 800; margin-top: 18px;">
            <span>مبلغ کل سفارش:</span>
            <span style="color: var(--brand);">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <!-- Delivery & Payment Meta -->
    <div style="display: flex; flex-direction: column; gap: 18px;">
        <div class="box">
            <h3 style="font-size: 16px; font-weight: 800; margin: 0 0 14px; padding-bottom: 10px; border-bottom: 1px solid var(--line);">
                اطلاعات تحویل و گیرنده
            </h3>
            <div style="font-size: 13px; display: grid; gap: 8px;">
                <div><span class="muted">نام گیرنده:</span> <b>{{ $order->receiver_name }}</b></div>
                <div><span class="muted">شماره موبایل:</span> <b dir="ltr">{{ $order->phone }}</b></div>
                <div><span class="muted">آدرس کامل:</span> <div>{{ $order->address }}</div></div>
                @if($order->notes)
                    <div><span class="muted">یادداشت:</span> <div>{{ $order->notes }}</div></div>
                @endif
            </div>
        </div>

        <div class="box">
            <h3 style="font-size: 16px; font-weight: 800; margin: 0 0 14px; padding-bottom: 10px; border-bottom: 1px solid var(--line);">
                اطلاعات پرداخت
            </h3>
            <div style="font-size: 13px; display: grid; gap: 8px;">
                <div>
                    <span class="muted">روش پرداخت:</span> 
                    <b>{{ $order->payment_method === 'online' ? 'درگاه آنلاین اینترنتی' : 'کارت‌به‌کارت بانکی' }}</b>
                </div>
                <div>
                    <span class="muted">وضعیت تراکنش:</span> 
                    <b>{{ $order->status }}</b>
                </div>
                @if($order->tracking_code)
                    <div>
                        <span class="muted">کد پیگیری / ارجاع:</span> 
                        <b dir="ltr" style="color: var(--brand);">{{ $order->tracking_code }}</b>
                    </div>
                @endif
                @if($order->receipt_image_url)
                    <div style="margin-top: 8px;">
                        <span class="muted" style="display: block; margin-bottom: 4px;">تصویر فیش واریزی شما:</span>
                        <a href="{{ $order->receipt_image_url }}" target="_blank">
                            <img src="{{ $order->receipt_image_url }}" alt="فیش واریز" style="max-height: 120px; border-radius: 8px; border: 1px solid var(--line);">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
