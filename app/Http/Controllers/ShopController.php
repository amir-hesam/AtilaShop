<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // فیلتر جستجو
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // فیلتر جنسیت (w: زنانه, m: مردانه)
        if ($request->filled('g')) {
            $query->where('gender', $request->g);
        }

        // فیلتر دسته‌بندی
        if ($request->filled('c')) {
            $query->where('category', $request->c);
        }

        // فیلتر نوع خاص (جدیدها، حراج)
        if ($request->x === 'new') {
            $query->where('tag', 'جدید');
        } elseif ($request->x === 'sale') {
            $query->whereNotNull('original_price')->whereRaw('original_price > price');
        }

        // فیلتر بازه قیمت
        if ($request->filled('pr')) {
            $parts = explode('-', $request->pr);
            if (count($parts) === 2) {
                if ($parts[0] !== '') {
                    $query->where('price', '>=', (int) $parts[0]);
                }
                if ($parts[1] !== '') {
                    $query->where('price', '<=', (int) $parts[1]);
                }
            }
        }

        // فیلتر علاقه‌مندی‌ها
        if ($request->boolean('w') && Auth::check()) {
            $userWishlistIds = Auth::user()->wishlistProducts()->pluck('products.id')->toArray();
            $query->whereIn('id', $userWishlistIds);
        }

        // مرتب‌سازی
        if ($request->s === 'cheap') {
            $query->orderBy('price', 'asc');
        } elseif ($request->s === 'exp') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        // صفحه‌بندی ۱۲ عددی مطابق FR-5
        $products = $query->paginate(12)->withQueryString();

        // دسته‌بندی‌های یکتا
        $categories = Product::distinct()->pluck('category')->toArray();

        // شناسه‌های علاقه‌مندی کاربر جاری
        $userWishlist = Auth::check() 
            ? Auth::user()->wishlistProducts()->pluck('products.id')->toArray() 
            : [];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'html' => view('partials.product_grid', compact('products', 'userWishlist'))->render(),
                'count' => $products->total(),
            ]);
        }

        return view('shop.index', compact('products', 'categories', 'userWishlist'));
    }

    public function show($id)
    {
        $product = is_numeric($id) 
            ? Product::findOrFail($id) 
            : Product::where('slug', $id)->firstOrFail();

        $related = Product::where('gender', $product->gender)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $userWishlist = Auth::check() 
            ? Auth::user()->wishlistProducts()->pluck('products.id')->toArray() 
            : [];

        return view('shop.show', compact('product', 'related', 'userWishlist'));
    }
}
