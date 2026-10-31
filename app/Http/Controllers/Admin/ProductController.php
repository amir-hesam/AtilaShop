<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('c')) {
            $query->where('category', $request->c);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('stock', '<', 6)->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Product::distinct()->pluck('category')->toArray();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ['ست لباس زیر', 'سوتین', 'شورت زنانه', 'بادی', 'لباس زیر مردانه'];
        $icons = [
            'set' => 'ست لباس زیر (شورت و سوتین)',
            'bra' => 'سوتین / نیم‌تنه',
            'panty' => 'شورت زنانه',
            'bodysuit' => 'بادی مجلسی',
            'boxer' => 'شورت مردانه (باکسر / اسلیپ)',
            'tee' => 'سایر / عمومی',
        ];

        return view('admin.products.create', compact('categories', 'icons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:w,m'],
            'price' => ['required', 'integer', 'min:0'],
            'original_price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sizes' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'hues' => ['nullable', 'string'],
            'tag' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'name.required' => 'نام محصول الزامی است.',
            'category.required' => 'دسته‌بندی الزامی است.',
            'price.required' => 'قیمت الزامی است.',
            'stock.required' => 'موجودی انبار الزامی است.',
            'sizes.required' => 'سایزهای موجود را وارد کنید.',
            'image.image' => 'فایل ارسالی باید تصویر معتبر باشد.',
            'image.max' => 'حجم تصویر نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        $sizesArray = array_map('trim', explode(',', $request->sizes));
        $huesArray = $request->hues ? array_map('intval', array_map('trim', explode(',', $request->hues))) : [345, 28, 205];

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000, 9999),
            'category' => $request->category,
            'gender' => $request->gender,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'stock' => $request->stock,
            'sizes' => $sizesArray,
            'icon' => $request->icon,
            'hues' => $huesArray,
            'tag' => $request->tag,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'محصول جدید با موفقیت اضافه شد.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ['ست لباس زیر', 'سوتین', 'شورت زنانه', 'بادی', 'لباس زیر مردانه'];
        $icons = [
            'set' => 'ست لباس زیر (شورت و سوتین)',
            'bra' => 'سوتین / نیم‌تنه',
            'panty' => 'شورت زنانه',
            'bodysuit' => 'بادی مجلسی',
            'boxer' => 'شورت مردانه (باکسر / اسلیپ)',
            'tee' => 'سایر / عمومی',
        ];

        return view('admin.products.edit', compact('product', 'categories', 'icons'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:w,m'],
            'price' => ['required', 'integer', 'min:0'],
            'original_price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sizes' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'hues' => ['nullable', 'string'],
            'tag' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $sizesArray = array_map('trim', explode(',', $request->sizes));
        $huesArray = $request->hues ? array_map('intval', array_map('trim', explode(',', $request->hues))) : ($product->hues ?? [345]);

        if ($request->boolean('remove_image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'gender' => $request->gender,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'stock' => $request->stock,
            'sizes' => $sizesArray,
            'icon' => $request->icon,
            'hues' => $huesArray,
            'tag' => $request->tag,
            'description' => $request->description,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'اطلاعات محصول با موفقیت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت حذف شد.');
    }
}
