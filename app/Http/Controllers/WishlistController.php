<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'auth' => false,
                'redirect' => route('login'),
                'message' => 'برای افزودن به علاقه‌مندی‌ها ابتدا باید وارد شوید.',
            ], 401);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
            $message = 'از لیست علاقه‌مندی‌ها حذف شد.';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $added = true;
            $message = 'به لیست علاقه‌مندی‌ها اضافه شد.';
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'auth' => true,
            'added' => $added,
            'count' => $count,
            'message' => $message,
        ]);
    }

    public function index()
    {
        $products = Auth::user()->wishlistProducts()->paginate(12);
        $userWishlist = Auth::user()->wishlistProducts()->pluck('products.id')->toArray();
        $categories = Product::distinct()->pluck('category')->toArray();

        return view('shop.wishlist', compact('products', 'userWishlist', 'categories'));
    }
}
