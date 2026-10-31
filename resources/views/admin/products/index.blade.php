@extends('layouts.admin')

@section('title', 'مدیریت محصولات | AtilaShop')
@section('breadcrumb', 'لیست و مدیریت موجودی محصولات')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 4px;">محصولات فروشگاه</h2>
        <div style="font-size: 13px; color: var(--muted);">تعداد کل محصولات: {{ $products->total() }} عدد</div>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn brand">
        + افزودن محصول جدید
    </a>
</div>

<!-- Filter Toolbar -->
<div class="box" style="margin-bottom: 22px; padding: 16px;">
    <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1 1 200px;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجوی نام لباس...">
        </div>

        <div style="flex: 0 1 160px;">
            <select name="c" onchange="this.form.submit()">
                <option value="">همه‌ی دسته‌بندی‌ها</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('c') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div style="flex: 0 1 140px;">
            <select name="gender" onchange="this.form.submit()">
                <option value="">زنانه و مردانه</option>
                <option value="w" {{ request('gender') === 'w' ? 'selected' : '' }}>زنانه</option>
                <option value="m" {{ request('gender') === 'm' ? 'selected' : '' }}>مردانه</option>
            </select>
        </div>

        <div style="flex: 0 1 160px;">
            <select name="stock_status" onchange="this.form.submit()">
                <option value="">وضعیت موجودی</option>
                <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>کسری موجودی (< ۶)</option>
                <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>ناموجود (۰ عدد)</option>
            </select>
        </div>

        <button type="submit" class="btn o" style="padding: 8px 16px;">فیلتر</button>
        @if(request()->hasAny(['q', 'c', 'gender', 'stock_status']))
            <a href="{{ route('admin.products.index') }}" class="btn o" style="color: var(--danger); padding: 8px 12px;">حذف فیلترها</a>
        @endif
    </form>
</div>

<!-- Products Table -->
<div class="box">
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width: 50px;">کد</th>
                    <th>نام محصول</th>
                    <th>دسته</th>
                    <th>جنسیت</th>
                    <th>قیمت فروش</th>
                    <th>قیمت خط‌خورده</th>
                    <th>موجودی</th>
                    <th>سایزها</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>
                            <div style="font-weight: 700;">{{ $p->name }}</div>
                            @if($p->tag)
                                <span style="font-size: 11px; color: var(--brand); font-weight: 600;">برچسب: {{ $p->tag }}</span>
                            @endif
                        </td>
                        <td>{{ $p->category }}</td>
                        <td>{{ $p->gender === 'w' ? 'زنانه' : 'مردانه' }}</td>
                        <td style="font-weight: 700;">{{ $p->formatted_price }}</td>
                        <td>{{ $p->formatted_original_price ?: '—' }}</td>
                        <td>
                            @if($p->stock <= 0)
                                <span class="badge-status badge-danger">ناموجود</span>
                            @elseif($p->stock < 6)
                                <span class="badge-status badge-warning">{{ $p->stock }} عدد (کمبود)</span>
                            @else
                                <span class="badge-status badge-success">{{ $p->stock }} عدد</span>
                            @endif
                        </td>
                        <td style="font-size: 12px;">
                            {{ is_array($p->sizes) ? implode('، ', $p->sizes) : $p->sizes }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.products.edit', $p->id) }}" class="btn o" style="padding: 4px 10px; font-size: 12px;">
                                    ویرایش
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger" style="padding: 4px 10px; font-size: 12px;">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: var(--muted); padding: 40px;">
                            هیچ محصولی با فیلترهای جاری پیدا نشد.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
