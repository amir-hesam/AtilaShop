@extends('layouts.admin')

@section('title', 'مدیریت سفارش‌ها | AtilaShop')
@section('breadcrumb', 'لیست و مدیریت وضعیت سفارش‌ها')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 4px;">سفارش‌های مشتریان</h2>
        <div style="font-size: 13px; color: var(--muted);">تعداد کل نتایج: {{ $orders->total() }} سفارش</div>
    </div>
</div>

<!-- Status Filter Tabs -->
<div style="display: flex; gap: 8px; margin-bottom: 18px; overflow-x: auto; padding-bottom: 4px;">
    <a href="{{ route('admin.orders.index') }}" 
       class="btn {{ !request('status') ? 'brand' : 'o' }}" style="padding: 6px 16px; font-size: 13px;">
        همه سفارش‌ها
    </a>
    @foreach($statuses as $st)
        @php
            $isTarget = request('status') === $st;
            $isPendingCard = $st === 'در انتظار تأیید پرداخت';
        @endphp
        <a href="{{ route('admin.orders.index', ['status' => $st]) }}" 
           class="btn {{ $isTarget ? 'brand' : 'o' }}" 
           style="padding: 6px 16px; font-size: 13px; {{ $isPendingCard && !$isTarget ? 'border-color: var(--warning); color: var(--warning);' : '' }}">
            {{ $st }}
            @if($isPendingCard)
                🔔
            @endif
        </a>
    @endforeach
</div>

<!-- Search Input -->
<div class="box" style="margin-bottom: 20px; padding: 14px 18px;">
    <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 10px;">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو بر اساس شماره سفارش، نام مشتری، شماره موبایل یا کد پیگیری بانکی...">
        <button type="submit" class="btn brand" style="padding: 8px 20px;">جستجو</button>
        @if(request('q'))
            <a href="{{ route('admin.orders.index', request()->only('status')) }}" class="btn o" style="padding: 8px 14px;">پاکسازی</a>
        @endif
    </form>
</div>

<!-- Orders Table -->
<div class="box">
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>نام مشتری</th>
                    <th>شماره تماس</th>
                    <th>مبلغ پرداختی</th>
                    <th>روش پرداخت</th>
                    <th>کد پیگیری / فیش</th>
                    <th>وضعیت سفارش</th>
                    <th>تاریخ ثبت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    @php
                        $badgeClass = match($o->status) {
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
                        <td style="font-weight: 800; font-size: 15px;">{{ $o->order_number }}</td>
                        <td>{{ $o->receiver_name }}</td>
                        <td dir="ltr">{{ $o->phone }}</td>
                        <td style="font-weight: 800; color: var(--brand);">{{ $o->formatted_total }}</td>
                        <td>
                            @if($o->payment_method === 'online')
                                <span style="font-size: 13px;">💳 آنلاین</span>
                            @else
                                <span style="font-size: 13px;">🏦 کارت‌به‌کارت</span>
                            @endif
                        </td>
                        <td dir="ltr" style="font-weight: 700; color: {{ $o->tracking_code ? 'var(--primary)' : 'var(--muted)' }};">
                            {{ $o->tracking_code ?: 'ثبت نشده' }}
                        </td>
                        <td>
                            <span class="badge-status {{ $badgeClass }}">
                                {{ $o->status }}
                            </span>
                            @if(!$o->isCancelled())
                                <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">گام {{ $o->step_index }} از ۵</div>
                            @endif
                        </td>
                        <td style="font-size: 12px; color: var(--muted);">
                            {{ $o->created_at->format('Y/m/d H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="btn o" style="padding: 5px 12px; font-size: 12px; font-weight: 700;">
                                بررسی و تغییر وضعیت
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: var(--muted); padding: 40px;">
                            هیچ سفارشی در این وضعیت یافت نشد.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection
