<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period   = $request->get('period', 'daily');
        $dateFrom = $request->get('date_from', today()->format('Y-m-d'));
        $dateTo   = $request->get('date_to', today()->format('Y-m-d'));
        $kantinId = $request->get('kantin_id', '');

        // Adjust date range for period shortcuts
        if ($period === 'weekly' && !$request->has('date_from')) {
            $dateFrom = now()->startOfWeek()->format('Y-m-d');
            $dateTo   = now()->endOfWeek()->format('Y-m-d');
        } elseif ($period === 'monthly' && !$request->has('date_from')) {
            $dateFrom = now()->startOfMonth()->format('Y-m-d');
            $dateTo   = now()->endOfMonth()->format('Y-m-d');
        }

        $base = Order::with(['user', 'menu.admin'])
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->when($kantinId, fn($q) => $q->whereHas('menu', fn($m) => $m->where('admin_id', $kantinId)));

        $orders       = (clone $base)->latest()->paginate(30)->withQueryString();
        $totalOrders  = (clone $base)->count();
        $totalRevenue = (clone $base)->where('status', 'completed')->sum('total_price');
        $pending      = (clone $base)->where('status', 'pending')->count();
        $completed    = (clone $base)->where('status', 'completed')->count();

        // Per-kantin breakdown
        $kantins  = User::where('role', 'admin')->orderBy('name')->get();
        $byKantin = $kantins->map(function ($admin) use ($dateFrom, $dateTo) {
            $q = Order::whereHas('menu', fn($m) => $m->where('admin_id', $admin->id))
                ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
            return [
                'name'    => $admin->name,
                'orders'  => (clone $q)->count(),
                'revenue' => (clone $q)->where('status', 'completed')->sum('total_price'),
            ];
        })->filter(fn($k) => $k['orders'] > 0)->values();

        // Status breakdown
        $allStatuses = ['pending', 'processing', 'ready', 'completed', 'cancelled'];
        $statusBreakdown = [];
        foreach ($allStatuses as $st) {
            $statusBreakdown[$st] = (clone $base)->where('status', $st)->count();
        }

        // Avg per day
        $daysDiff = max(1, \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1);
        $avgPerDay = $totalRevenue / $daysDiff;

        $completedOrders = $completed;

        return view('superadmin.reports.index', compact(
            'orders', 'totalOrders', 'totalRevenue', 'completedOrders', 'avgPerDay',
            'byKantin', 'statusBreakdown', 'kantins', 'period', 'dateFrom', 'dateTo', 'kantinId'
        ));
    }
}
