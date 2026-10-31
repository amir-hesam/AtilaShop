@extends('layouts.app')

@section('title', 'سفارش‌های من | AtilaShop')

@section('content')

<div style="margin: 20px 0 28px;">
    <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 6px;">سفارش‌های من</h1>
    <p class="muted" style="margin: 0;">تاریخچه و وضعیت سفارش‌های ثبت‌شده‌ی شما در آتیلاشاپ</p>
</div>

@if($orders->count() > 0)
    <div style="display: grid; gap: 16px;">
        @foreach($orders as $order)
            <div class="box" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <span style="font-weight: 800; font-size: 16px;">سفارش {{ $order->order_number }}</span>
                        <span style="font-size: 12px; font-weight: 700; padding: 3px 12px; border-radius: 99px; border: 1px solid var(--line); background: var(--bg);">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="muted" style="font-size: 13px;">
                        ثبت شده در: {{ $order->created_at->format('Y/m/d H:i') }} · 
                        تعداد اقلام: {{ $order->items->sum('quantity') }} عدد · 
                        روش پرداخت: {{ $order->payment_method === 'online' ? 'درگاه آنلاین' : 'کارت‌به‌کارت' }}
                    </div>

                    @if(!$order->isCancelled())
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                            <div style="font-size: 12px; font-weight: 700; color: var(--brand);">
                                مرحله {{ $order->step_index }} از ۵ ({{ $order->status }})
                            </div>
                            <div style="width: 110px; height: 6px; background: var(--line); border-radius: 99px; overflow: hidden;">
                                <div style="height: 100%; width: {{ ($order->step_index / 5) * 100 }}%; background: var(--brand); border-radius: 99px;"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="font-size: 18px; font-weight: 800; color: var(--brand);">
                        {{ $order->formatted_total }}
                    </div>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn o" style="padding: 8px 18px; font-size: 13px;">
                        مشاهده جزئیات
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($orders->hasPages())
        <div style="margin-top: 32px; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
    @endif
@else
    <div class="box" style="text-align: center; padding: 60px 20px;">
        <svg class="ic" style="width: 56px; height: 56px; color: var(--muted); stroke-width: 1.2; margin-bottom: 16px;"><use href="#i-orders"/></svg>
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">هنوز سفارشی ثبت نکرده‌اید</h3>
        <p class="muted" style="max-width: 380px; margin: 0 auto 20px;">
            می‌توانید محصولات را بررسی کرده و اولین سفارش خود را ثبت کنید.
        </p>
        <a href="{{ route('home') }}" class="btn">شروع خرید از فروشگاه</a>
    </div>
@endif

@endsection
