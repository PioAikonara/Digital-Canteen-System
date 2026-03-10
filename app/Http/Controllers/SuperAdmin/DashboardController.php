<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\TopUp;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::where('role', 'customer')->count();
        $totalAdmins   = User::where('role', 'admin')->count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status', 'completed')->sum('total_price');
        $todayOrders   = Order::whereDate('created_at', today())->count();
        $todayRevenue  = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalMenus    = Menu::count();

        // Top kantins by revenue
        $topKantins = User::where('role', 'admin')->get()->map(function ($admin) {
            $admin->total_revenue = Order::whereHas('menu', fn($q) => $q->where('admin_id', $admin->id))
                ->where('status', 'completed')->sum('total_price');
            $admin->total_orders = Order::whereHas('menu', fn($q) => $q->where('admin_id', $admin->id))->count();
            $admin->menu_count   = Menu::where('admin_id', $admin->id)->count();
            return $admin;
        })->sortByDesc('total_revenue')->take(5);

        // Recent orders (all kantins)
        $recentOrders = Order::with(['user', 'menu.admin'])->latest()->take(10)->get();

        // Weekly data (last 7 days)
        $weeklyData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'label'   => $date->format('D'),
                'orders'  => Order::whereDate('created_at', $date)->count(),
                'revenue' => (int) Order::where('status', 'completed')->whereDate('created_at', $date)->sum('total_price'),
            ];
        });

        // Recent top-ups
        $recentTopUps = TopUp::with('user')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalUsers', 'totalAdmins', 'totalOrders', 'totalRevenue',
            'todayOrders', 'todayRevenue', 'pendingOrders', 'totalMenus',
            'topKantins', 'recentOrders', 'weeklyData', 'recentTopUps'
        ));
    }
}
