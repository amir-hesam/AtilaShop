<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'پرداخت شده')->sum('total_amount');
        $totalOrdersCount = Order::count();
        $pendingCardApprovalsCount = Order::where('status', 'در انتظار تأیید پرداخت')->count();
        $pendingOrdersCount = Order::where('status', 'در انتظار پرداخت')->count();
        $lowStockProducts = Product::where('stock', '<', 6)->get();
        $totalProductsCount = Product::count();
        $totalUsersCount = User::where('is_admin', false)->count();

        $recentOrders = Order::with('user', 'items')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrdersCount',
            'pendingCardApprovalsCount',
            'pendingOrdersCount',
            'lowStockProducts',
            'totalProductsCount',
            'totalUsersCount',
            'recentOrders'
        ));
    }
}
