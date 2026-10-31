@extends('layouts.admin')

@section('title', 'مدیریت سفارش ' . $order->order_number . ' | AtilaShop')
@section('breadcrumb', 'بررسی سفارش: ' . $order->order_number)

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 4px;">سفارش {{ $order->order_number }}</h2>
        <div style="font-size: 13px; color: var(--muted);">تاریخ ثبت: {{ $order->created_at->format('Y/m/d H:i') }}</div>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn o" style="font-size: 13px;">بازگشت به لیست سفارش‌ها</a>
</div>

<!-- Special Highlight Card for Card-to-Card Approval -->
@if($order->status === 'در انتظار تأیید پرداخت')
    <div class="box" style="background: #fffbeb; border: 2px solid #fde68a; margin-bottom: 22px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
                <h3 style="margin: 0 0 6px; font-size: 16px; color: #92400e; font-weight: 800;">
                    ⚠️ این سفارش پرداخت کارت‌به‌کارت داشته و منتظر بررسی و تأیید واریز توسط شماست.
                </h3>
                <div style="font-size: 14px; color: #78350f;">
                    کد پیگیری واردشده توسط مشتری: <b dir="ltr" style="font-size: 16px;">{{ $order->tracking_code }}</b>
                </div>

                @if($order->receipt_image_url)
                    <div style="margin-top: 10px;">
                        <span style="font-size: 12px; font-weight: 700; color: #92400e;">عکس فیش واریزی ارسال شده:</span>
                        <div style="margin-top: 6px;">
                            <a href="{{ $order->receipt_image_url }}" target="_blank">
                                <img src="{{ $order->receipt_image_url }}" alt="فیش واریز" style="max-height: 180px; border-radius: 10px; border: 2px solid #f59e0b; box-shadow: 0 4px 12px rgba(0,0,0,.1); cursor: pointer;" title="برای بزرگ‌نمایی کلیک کنید">
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.orders.update_status', $order->id) }}">
                @csrf
                <input type="hidden" name="status" value="تأیید پرداخت">
                <input type="hidden" name="status_note" value="فیش واریز شما تأیید شد و سفارش به مرحله بسته‌بندی رفت.">
                <button type="submit" class="btn" style="background: #10b981; color: #fff; padding: 10px 22px; font-size: 14px;">
                    ✓ تأیید فیش و ورود به مرحله بعدی (تأیید پرداخت)
                </button>
            </form>
        </div>
    </div>
@endif

<!-- Order Stepper Stage Indicator in Admin -->
<div class="box" style="margin-bottom: 22px; padding: 18px 22px; background: color-mix(in srgb, var(--brand) 5%, var(--card)); border: 1px solid var(--line);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <span style="font-size: 13px; color: var(--muted);">مرحله فعلی سفارش در نوار پیگیری دیجی‌کالایی مشتری:</span>
            <div style="font-size: 17px; font-weight: 800; color: var(--brand); margin-top: 2px;">
                @if($order->isCancelled())
                    ❌ لغو شده
                @else
                    مرحله {{ $order->step_index }} از ۵ — {{ $order->status }}
                @endif
            </div>
        </div>
        <div style="font-size: 13px; color: var(--muted);">
            روش پرداخت: <b>{{ $order->payment_method === 'online' ? 'درگاه آنلاین' : 'کارت‌به‌کارت' }}</b> · مبلغ: <b>{{ $order->formatted_total }}</b>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.4fr .8fr; gap: 24px; align-items: start;">
    <!-- Items Table -->
    <div class="box">
        <h3 style="margin: 0 0 16px; font-size: 17px; font-weight: 700; padding-bottom: 12px; border-bottom: 1px solid var(--line);">
            اقلام خریداری شده در این سفارش
        </h3>

        <div class="table-responsive">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>نام کالا</th>
                        <th>سایز</th>
                        <th>تعداد</th>
                        <th>قیمت واحد</th>
                        <th>جمع ردیف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td style="font-weight: 700;">{{ $item->product_name }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $item->quantity }} عدد</td>
                            <td>{{ $item->formatted_unit_price }}</td>
                            <td style="font-weight: 800; color: var(--brand);">{{ $item->formatted_total_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 18px; font-weight: 800; margin-top: 20px; padding-top: 14px; border-top: 1px solid var(--line);">
            <span>مبلغ کل سفارش:</span>
            <span style="color: var(--brand);">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <!-- Management Controls & Customer Meta -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Status & Shipping Stepper Manager Form (Digikala Style) -->
        <div class="box">
            <h3 style="margin: 0 0 14px; font-size: 16px; font-weight: 700; padding-bottom: 10px; border-bottom: 1px solid var(--line); display: flex; align-items: center; gap: 8px;">
                <svg class="ic" style="color: var(--brand); width: 20px; height: 20px;"><use href="#i-truck"/></svg>
                <span>مدیریت وضعیت ارسال (نوار پیگیری)</span>
            </h3>

            <form method="POST" action="{{ route('admin.orders.update_status', $order->id) }}">
                @csrf

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                        مرحله نوار سفارش (مطابق دیجی‌کالا):
                    </label>
                    <select name="status" style="font-weight: 600;">
                        <option value="در انتظار پرداخت" {{ $order->status === 'در انتظار پرداخت' ? 'selected' : '' }}>۱. در انتظار پرداخت (قبل از فیش)</option>
                        <option value="در انتظار تأیید پرداخت" {{ $order->status === 'در انتظار تأیید پرداخت' ? 'selected' : '' }}>۲. در انتظار تأیید فیش (فیش ارسال شده)</option>
                        <option value="تأیید پرداخت" {{ in_array($order->status, ['تأیید پرداخت', 'پرداخت شده']) ? 'selected' : '' }}>۳. تأیید پرداخت (فیش یا درگاه تأیید شد)</option>
                        <option value="در حال آماده‌سازی و بسته‌بندی" {{ $order->status === 'در حال آماده‌سازی و بسته‌بندی' ? 'selected' : '' }}>۴. در حال آماده‌سازی و بسته‌بندی محرمانه</option>
                        <option value="تحویل به پست / ارسال شده" {{ $order->status === 'تحویل به پست / ارسال شده' ? 'selected' : '' }}>۵. تحویل به پست / ارسال شده</option>
                        <option value="تحویل داده شد" {{ $order->status === 'تحویل داده شد' ? 'selected' : '' }}>۶. تحویل مرسوله به خریدار</option>
                        <option value="لغو شده" {{ $order->status === 'لغو شده' ? 'selected' : '' }}>❌ لغو سفارش / عدم تأیید فیش</option>
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                        کد رهگیری پستی / تیپاکس (اختیاری جهت ارسال به مشتری):
                    </label>
                    <input type="text" name="tracking_code" value="{{ $order->tracking_code }}" placeholder="مثلاً: 241098239019283746501928" dir="ltr" style="font-family: monospace; font-size: 13px;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                        یادداشت وضعیت برای مشتری (اختیاری):
                    </label>
                    <input type="text" name="status_note" placeholder="مثلاً: بسته تحویل پست پیشتاز گردید">
                </div>

                <button type="submit" class="btn brand" style="width: 100%; justify-content: center; font-size: 14px;">
                    🚀 ثبت تغییر مرحله و ارسال نوتیفیکیشن به مشتری
                </button>

                <p class="muted" style="font-size: 11.5px; margin: 10px 0 0; line-height: 1.6;">
                    * با ثبت این فرم، نوار خطی وضعیت در پنل و صفحه پیگیری مشتری در لحظه آپدیت شده و اعلان درون‌سایت (نوتیفیکیشن) برای مشتری ارسال می‌شود.
                </p>
            </form>
        </div>

        <!-- Customer & Delivery Info -->
        <div class="box">
            <h3 style="margin: 0 0 14px; font-size: 16px; font-weight: 700; padding-bottom: 10px; border-bottom: 1px solid var(--line);">
                مشخصات تحویل‌گیرنده
            </h3>
            <div style="display: grid; gap: 8px; font-size: 13px;">
                <div><span class="muted">نام خریدار:</span> <b>{{ $order->user ? $order->user->name : 'مشتری مهمان' }}</b></div>
                <div><span class="muted">ایمیل خریدار:</span> <span dir="ltr">{{ $order->user ? $order->user->email : '—' }}</span></div>
                <div><span class="muted">نام گیرنده:</span> <b>{{ $order->receiver_name }}</b></div>
                <div><span class="muted">شماره موبایل:</span> <b dir="ltr">{{ $order->phone }}</b></div>
                <div><span class="muted">آدرس پستی:</span> <div>{{ $order->address }}</div></div>
                @if($order->notes)
                    <div><span class="muted">توضیحات:</span> <div>{{ $order->notes }}</div></div>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        <div class="box">
            <h3 style="margin: 0 0 14px; font-size: 16px; font-weight: 700; padding-bottom: 10px; border-bottom: 1px solid var(--line);">
                اطلاعات پرداخت
            </h3>
            <div style="display: grid; gap: 8px; font-size: 13px;">
                <div>
                    <span class="muted">روش پرداخت:</span> 
                    <b>{{ $order->payment_method === 'online' ? 'درگاه آنلاین' : 'کارت‌به‌کارت' }}</b>
                </div>
                <div>
                    <span class="muted">کد پیگیری:</span> 
                    <b dir="ltr" style="color: var(--brand);">{{ $order->tracking_code ?: 'ثبت نشده' }}</b>
                </div>
                @if($order->receipt_image_url)
                    <div style="margin-top: 6px;">
                        <span class="muted" style="display: block; margin-bottom: 4px;">فیش واریزی پیوست‌شده:</span>
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
