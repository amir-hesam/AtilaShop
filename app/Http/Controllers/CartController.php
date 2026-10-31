<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    const FREE_SHIPPING_THRESHOLD = 2000000;

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $key => $item) {
            $total += $item['price'] * $item['qty'];
        }

        $freeShippingThreshold = self::FREE_SHIPPING_THRESHOLD;
        $remainingForFreeShipping = max(0, $freeShippingThreshold - $total);

        return response()->json([
            'items' => array_values($cart),
            'total' => $total,
            'total_formatted' => number_format($total) . ' تومان',
            'count' => array_sum(array_column($cart, 'qty')),
            'free_shipping' => $total >= $freeShippingThreshold,
            'remaining_for_free' => $remainingForFreeShipping,
            'remaining_formatted' => number_format($remainingForFreeShipping) . ' تومان',
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:products,id'],
            'size' => ['required', 'string'],
            'ci' => ['nullable', 'integer'],
        ]);

        $product = Product::findOrFail($request->id);

        if ($product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'این محصول متأسفانه ناموجود است.',
            ], 422);
        }

        $size = $request->size;
        $ci = (int) $request->input('ci', 0);
        $cartKey = "{$product->id}_{$size}_{$ci}";

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] = min(10, $cart[$cartKey]['qty'] + 1);
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'size' => $size,
                'ci' => $ci,
                'icon' => $product->icon,
                'hues' => $product->hues ?? [345],
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);

        $totalCount = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'success' => true,
            'message' => 'به سبد خرید اضافه شد.',
            'count' => $totalCount,
            'cart' => $cart,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
            'delta' => ['required', 'integer'],
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (isset($cart[$key])) {
            $newQty = $cart[$key]['qty'] + $request->delta;
            if ($newQty <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['qty'] = min(10, $newQty);
            }
            session()->put('cart', $cart);
        }

        return $this->index();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return $this->index();
    }
}
