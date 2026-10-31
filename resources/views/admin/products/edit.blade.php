@extends('layouts.admin')

@section('title', 'ویرایش محصول: ' . $product->name . ' | AtilaShop')
@section('breadcrumb', 'ویرایش مشخصات و موجودی: ' . $product->name)

@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
            <h2 style="font-size: 20px; font-weight: 800; margin: 0;">ویرایش محصول</h2>
            <a href="{{ route('admin.products.index') }}" class="btn o" style="font-size: 13px;">بازگشت به لیست</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-inline-start: 18px; font-size: 13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Image Upload / Current Image -->
            <div style="background: var(--bg); border: 2px dashed var(--line); border-radius: 16px; padding: 20px; text-align: center; margin-bottom: 22px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px;">
                    📷 عکس محصول
                </label>

                @if($product->image_url)
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 12px; color: var(--muted); margin-bottom: 6px;">تصویر فعلی:</div>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-height: 160px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 4px 12px rgba(0,0,0,.08); display: block; margin: 0 auto;">
                        <label style="display: inline-flex; align-items: center; gap: 6px; margin-top: 8px; font-size: 13px; color: var(--danger); cursor: pointer;">
                            <input type="checkbox" name="remove_image" value="1" style="width: auto;">
                            <span>حذف تصویر فعلی (و بازگشت به آیکون وکتور)</span>
                        </label>
                    </div>
                @endif

                <div class="muted" style="font-size: 12px; margin-bottom: 10px;">
                    انتخاب تصویر جدید (فرمت‌های JPG, PNG, WEBP - حداکثر ۵ مگابایت):
                </div>
                <input type="file" name="image" id="prod-img-input" accept="image/*" style="max-width: 300px; margin: 0 auto; display: block;" onchange="previewImage(this)">
                <div id="img-preview-box" style="margin-top: 14px; display: none;">
                    <div style="font-size: 12px; color: var(--muted); margin-bottom: 4px;">پیش‌نمایش تصویر جدید:</div>
                    <img id="img-preview" src="" alt="پیش‌نمایش" style="max-height: 160px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 4px 12px rgba(0,0,0,.08);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نام محصول *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">دسته‌بندی *</label>
                    <select name="category" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">جنسیت *</label>
                    <select name="gender" required>
                        <option value="w" {{ old('gender', $product->gender) === 'w' ? 'selected' : '' }}>زنانه</option>
                        <option value="m" {{ old('gender', $product->gender) === 'm' ? 'selected' : '' }}>مردانه</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">قیمت فروش (تومان) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">قیمت اصلی / تخفیف (تومان)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">موجودی انبار *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">سایزها (با کاما جدا کنید) *</label>
                    <input type="text" name="sizes" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes) }}" required>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">برچسب بازاریابی</label>
                    <input type="text" name="tag" value="{{ old('tag', $product->tag) }}" placeholder="مثلاً: جدید یا پرفروش">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نوع وکتور / آیکون لباس *</label>
                    <select name="icon" required>
                        @foreach($icons as $key => $lbl)
                            <option value="{{ $key }}" {{ old('icon', $product->icon) === $key ? 'selected' : '' }}>{{ $lbl }} ({{ $key }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">کدهای رنگی HSL (با کاما)</label>
                    <input type="text" name="hues" value="{{ old('hues', is_array($product->hues) ? implode(', ', $product->hues) : '345') }}">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">توضیحات و مشخصات لباس</label>
                <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('admin.products.index') }}" class="btn o">انصراف</a>
                <button type="submit" class="btn brand" style="padding: 10px 28px;">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const previewBox = document.getElementById('img-preview-box');
        const previewImg = document.getElementById('img-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewBox.style.display = 'none';
        }
    }
</script>
@endsection
