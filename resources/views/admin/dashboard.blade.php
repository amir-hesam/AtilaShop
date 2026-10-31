@extends('layouts.admin')

@section('title', 'داشبورد مدیریت | AtilaShop')
@section('breadcrumb', 'داشبورد اصلی و گزارش‌های عملکرد')

@section('content')

<!-- Stat Metrics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <!-- Metric 1: Total Sales -->
    <div class="box" style="border-right: 4px solid var(--success);">
        <div style="font-size: 13px; color: var(--muted); margin-bottom: 6px;">مجموع فروش‌های موفق</div>
        <div style="font-size: 22px; font-weight: 800; color: var(--success);">
            {{ number_format($totalSales) }} تومان
        </div>
    </div>

    <!-- Metric 2: Total Orders -->
    <div class="box" style="border-right: 4px solid var(--primary);">
        <div style="font-size: 13px; color: var(--muted); margin-bottom: 6px;">کل سفارش‌های ثبت‌شده</div>
        <div style="font-size: 22px; font-weight: 800;">
            {{ number_format($totalOrdersCount) }} سفارش
        </div>
    </div>

    <!-- Metric 3: Pending Card Approvals -->
    <div class="box" style="border-right: 4px solid var(--warning); background: {{ $pendingCardApprovalsCount > 0 ? 'color-mix(in srgb, var(--warning) 6%, var(--card))' : 'var(--card)' }};">
        <div style="font-size: 13px; color: var(--muted); margin-bottom: 6px;">در انتظار تأیید کارت‌به‌کارت</div>
        <div style="font-size: 22px; font-weight: 800; color: var(--warning);">
            {{ number_format($pendingCardApprovalsCount) }} فیش واریز
        </div>
    </div>

    <!-- Metric 4: Low Stock Products -->
    <div class="box" style="border-right: 4px solid var(--danger);">
        <div style="font-size: 13px; color: var(--muted); margin-bottom: 6px;">هشدار کسری موجودی (زیر ۶ عدد)</div>
        <div style="font-size: 22px; font-weight: 800; color: var(--danger);">
            {{ number_format($lowStockProducts->count()) }} محصول
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div style="display: flex; gap: 12px; margin-bottom: 28px; flex-wrap: wrap;">
    <a href="{{ route('admin.products.create') }}" class="btn brand">
        + افزودن محصول جدید
    </a>
    @if($pendingCardApprovalsCount > 0)
        <a href="{{ route('admin.orders.index', ['status' => 'در انتظار تأیید پرداخت']) }}" class="btn" style="background: var(--warning); color: #fff;">
            بررسی {{ $pendingCardApprovalsCount }} سفارش منتظر تأیید فیش
        </a>
    @endif
    <a href="{{ route('admin.orders.index') }}" class="btn o">
        مشاهده همه سفارش‌ها
    </a>
</div>

<!-- Recent Orders Section -->
<div class="box" style="margin-bottom: 28px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="margin: 0; font-size: 17px; font-weight: 700;">سفارش‌های اخیر</h3>
        <a href="{{ route('admin.orders.index') }}" style="font-size: 13px; color: var(--brand); font-weight: 600;">مشاهده همه</a>
    </div>

    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>مشتری</th>
                    <th>موبایل</th>
                    <th>مبلغ کل</th>
                    <th>روش پرداخت</th>
                    <th>کد رهگیری</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    @php
                        $badgeClass = match($order->status) {
                            'پرداخت شده', 'تأیید پرداخت' => 'badge-success',
                            'در انتظار تأیید پرداخت' => 'badge-warning',
                            'در حال آماده‌سازی و بسته‌بندی' => 'badge-info',
                            'تحویل به پست / ارسال شده' => 'badge-info',
                            'تحویل داده شد' => 'badge-success',
                            'پرداخت ناموفق', 'لغو شده' => 'badge-danger',
                            default => 'badge-info',
                        };
                    @endphp
                    <tr>
                        <td style="font-weight: 700;">{{ $order->order_number }}</td>
                        <td>{{ $order->receiver_name }}</td>
                        <td dir="ltr">{{ $order->phone }}</td>
                        <td style="font-weight: 700;">{{ $order->formatted_total }}</td>
                        <td>{{ $order->payment_method === 'online' ? 'درگاه آنلاین' : 'کارت‌به‌کارت' }}</td>
                        <td dir="ltr">{{ $order->tracking_code ?: '—' }}</td>
                        <td>
                            <span class="badge-status {{ $badgeClass }}">{{ $order->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn o" style="padding: 4px 10px; font-size: 12px;">
                                بررسی / تغییر وضعیت
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--muted); padding: 30px;">
                            هنوز سفارشی ثبت نشده است.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Low Stock Warning Table -->
@if($lowStockProducts->count() > 0)
    <div class="box">
        <h3 style="margin: 0 0 16px; font-size: 17px; font-weight: 700; color: var(--danger);">
            هشدار موجودی کالاهای رو به اتمام (کمتر از ۶ عدد)
        </h3>
        <div class="table-responsive">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>نام محصول</th>
                        <th>دسته‌بندی</th>
                        <th>قیمت</th>
                        <th>موجودی باقی‌مانده</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $lp)
                        <tr>
                            <td style="font-weight: 700;">{{ $lp->name }}</td>
                            <td>{{ $lp->category }}</td>
                            <td>{{ $lp->formatted_price }}</td>
                            <td>
                                <span class="badge-status badge-danger">
                                    {{ $lp->stock <= 0 ? 'ناموجود (۰ عدد)' : "فقط {$lp->stock} عدد" }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $lp->id) }}" class="btn o" style="padding: 4px 10px; font-size: 12px;">
                                    افزایش موجودی
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
