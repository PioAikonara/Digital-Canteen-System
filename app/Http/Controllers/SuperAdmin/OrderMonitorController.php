<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderMonitorController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->get('status', '');
        $kantinId = $request->get('kantin_id', '');
        $date     = $request->get('date', today()->format('Y-m-d'));
        $search   = $request->get('search', '');

        $query = Order::with(['user', 'menu.admin'])
            ->when($status,   fn($q) => $q->where('status', $status))
            ->when($kantinId, fn($q) => $q->whereHas('menu', fn($m) => $m->where('admin_id', $kantinId)))
            ->when($date,     fn($q) => $q->whereDate('created_at', $date))
            ->when($search,   fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                ->orWhereHas('menu', fn($m) => $m->where('name', 'like', "%$search%")))
            ->latest();

        $orders  = $query->paginate(25)->withQueryString();
        $kantins = User::where('role', 'admin')->orderBy('name')->get();

        $counts = [
            'all'       => Order::when($date, fn($q) => $q->whereDate('created_at', $date))->count(),
            'pending'   => Order::where('status', 'pending')->when($date, fn($q) => $q->whereDate('created_at', $date))->count(),
            'preparing' => Order::where('status', 'preparing')->when($date, fn($q) => $q->whereDate('created_at', $date))->count(),
            'ready'     => Order::where('status', 'ready')->when($date, fn($q) => $q->whereDate('created_at', $date))->count(),
            'completed' => Order::where('status', 'completed')->when($date, fn($q) => $q->whereDate('created_at', $date))->count(),
        ];

        $currentStatus = $status;

        return view('superadmin.orders.index', compact(
            'orders', 'kantins', 'counts', 'currentStatus', 'kantinId', 'date', 'search'
        ));
    }
}
