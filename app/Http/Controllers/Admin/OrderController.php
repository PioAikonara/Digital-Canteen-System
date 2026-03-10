<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->id();

        $query = Order::with(['user', 'menu'])
            ->whereHas('menu', fn($q) => $q->where('admin_id', $adminId))
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest();

        // Filter berdasarkan waktu istirahat
        if ($request->filled('pickup_time')) {
            $query->where('pickup_time', $request->pickup_time);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20)->withQueryString();

        // Count pesanan per status (hanya kantin ini)
        $pendingCount   = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'pending')->count();
        $preparingCount = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'preparing')->count();
        $readyCount     = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'ready')->count();

        return view('admin.orders.index', compact('orders', 'pendingCount', 'preparingCount', 'readyCount'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed',
        ]);

        // Pastikan order ini milik kantin admin yang sedang login
        abort_if($order->menu->admin_id !== auth()->id(), 403);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function history(Request $request)
    {
        $adminId = auth()->id();

        $query = Order::with(['user', 'menu'])
            ->whereHas('menu', fn($q) => $q->where('admin_id', $adminId))
            ->where('status', 'completed')
            ->latest();

        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('updated_at', $request->date);
        }

        // Filter berdasarkan waktu pengambilan
        if ($request->has('pickup_time') && $request->pickup_time != '') {
            $query->where('pickup_time', $request->pickup_time);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.history', compact('orders'));
    }

    public function destroy(Order $order)
    {
        // Pastikan order ini milik kantin admin yang sedang login
        abort_if($order->menu->admin_id !== auth()->id(), 403);

        $order->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
