@extends('layouts.admin')

@section('title', 'افزودن محصول جدید | AtilaShop')
@section('breadcrumb', 'افزودن لباس جدید به کاتالوگ فروشگاه')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 14px; border-bottom: 1px solid var(--line);">
            <h2 style="font-size: 20px; font-weight: 800; margin: 0;">مشخصات محصول جدید</h2>
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

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Product Image Upload -->
            <div style="background: var(--bg); border: 2px dashed var(--line); border-radius: 16px; padding: 20px; text-align: center; margin-bottom: 22px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px; cursor: pointer;">
                    📷 بارگذاری عکس محصول (اختیاری)
                </label>
                <div class="muted" style="font-size: 12px; margin-bottom: 12px;">
                    فرمت‌های مجاز: JPG, PNG, WEBP (حداکثر ۵ مگابایت) · در صورت عدم انتخاب عکس، آیکون گرافیکی وکتور نمایش داده می‌شود.
                </div>
                <input type="file" name="image" id="prod-img-input" accept="image/*" style="max-width: 300px; margin: 0 auto; display: block;" onchange="previewImage(this)">
                <div id="img-preview-box" style="margin-top: 14px; display: none;">
                    <img id="img-preview" src="" alt="پیش‌نمایش" style="max-height: 160px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 4px 12px rgba(0,0,0,.08);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نام محصول *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثلاً: ست شورت و سوتین دانتل مجلسی">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">دسته‌بندی *</label>
                    <select name="category" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">جنسیت *</label>
                    <select name="gender" required>
                        <option value="w" {{ old('gender') === 'w' ? 'selected' : '' }}>زنانه</option>
                        <option value="m" {{ old('gender') === 'm' ? 'selected' : '' }}>مردانه</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">قیمت فروش (تومان) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required placeholder="مثلاً: 850000">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">قیمت اصلی / خط‌خورده (تومان)</label>
                    <input type="number" name="original_price" value="{{ old('original_price') }}" placeholder="اختیاری جهت تخفیف">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">موجودی انبار *</label>
                    <input type="number" name="stock" value="{{ old('stock', 10) }}" required min="0">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">سایزها (با کاما جدا کنید) *</label>
                    <input type="text" name="sizes" value="{{ old('sizes', '75B, 80B, 85B, 90B') }}" required placeholder="75B, 80B یا M, L, XL">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">برچسب بازاریابی</label>
                    <input type="text" name="tag" value="{{ old('tag') }}" placeholder="مثلاً: جدید یا پرفروش">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">نوع وکتور / آیکون لباس *</label>
                    <select name="icon" required>
                        @foreach($icons as $key => $lbl)
                            <option value="{{ $key }}" {{ old('icon') === $key ? 'selected' : '' }}>{{ $lbl }} ({{ $key }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">کدهای رنگی HSL (با کاما)</label>
                    <input type="text" name="hues" value="{{ old('hues', '345, 28, 205') }}" placeholder="345, 28, 205">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">توضیحات و مشخصات لباس</label>
                <textarea name="description" rows="4" placeholder="توضیحاتی درباره جنس پارچه، قد لباس، نحوه شستشو و تن‌خور...">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('admin.products.index') }}" class="btn o">انصراف</a>
                <button type="submit" class="btn brand" style="padding: 10px 28px;">
                    ذخیره و انتشار محصول
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
