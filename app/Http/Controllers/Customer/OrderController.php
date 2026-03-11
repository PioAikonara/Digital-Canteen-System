<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::where('is_available', true)
            ->where('stock', '>', 0);
        
        // Filter by food category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by kantin (admin) if provided
        if ($request->filled('kantin')) {
            $query->where('admin_id', $request->kantin);
        }
        
        $menus = $query->get();

        // Get all admin users ordered by id to assign kantin numbers
        $admins = User::where('role', 'admin')->orderBy('id')->get();
        
        return view('customer.order.index', compact('menus', 'admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'pickup_time' => 'required|in:istirahat_1,istirahat_2',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $menu = Menu::findOrFail($validated['menu_id']);

            // Check stock availability
            if ($menu->stock < $validated['quantity']) {
                return back()->with('error', 'Stok tidak mencukupi! Tersedia: ' . $menu->stock . ' porsi');
            }

            // Calculate total price
            $totalPrice = $menu->price * $validated['quantity'];

            // Check balance
            $user = auth()->user();
            if ($user->balance < $totalPrice) {
                return back()->with('error', 'Saldo tidak mencukupi! Saldo kamu: Rp ' . number_format($user->balance, 0, ',', '.') . ', dibutuhkan: Rp ' . number_format($totalPrice, 0, ',', '.'));
            }

            // Deduct balance
            $user->decrement('balance', $totalPrice);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'menu_id' => $validated['menu_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
                'pickup_time' => $validated['pickup_time'],
                'notes' => $validated['notes'],
                'status' => 'pending',
            ]);

            // Reduce stock
            $menu->decrement('stock', $validated['quantity']);

            // Auto-update is_available if stock is 0
            if ($menu->stock <= 0) {
                $menu->update(['is_available' => false]);
            }

            DB::commit();

            return redirect()->route('customer.orders.index')
                ->with('success', 'Pesanan berhasil dibuat! Saldo berkurang Rp ' . number_format($totalPrice, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.notes'      => 'nullable|string|max:500',
            'pickup_time'        => 'required|in:istirahat_1,istirahat_2',
        ]);

        try {
            DB::beginTransaction();

            $user = User::lockForUpdate()->find(auth()->id());
            $totalBatch = 0;

            // Pre-check all stocks and calculate total
            foreach ($validated['items'] as $item) {
                $menu = Menu::where('id', $item['menu_id'])->lockForUpdate()->firstOrFail();
                if ($menu->stock < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', 'Stok "' . $menu->name . '" tidak mencukupi! Tersedia: ' . $menu->stock . ' porsi.');
                }
                $totalBatch += $menu->price * $item['quantity'];
            }

            // Check balance
            if ($user->balance < $totalBatch) {
                DB::rollBack();
                return back()->with('error', 'Saldo tidak mencukupi! Saldo kamu: Rp ' . number_format($user->balance, 0, ',', '.') . ', dibutuhkan: Rp ' . number_format($totalBatch, 0, ',', '.'));
            }

            // Deduct balance once
            $user->decrement('balance', $totalBatch);

            foreach ($validated['items'] as $item) {
                $menu = Menu::find($item['menu_id']);

                Order::create([
                    'user_id'    => auth()->id(),
                    'menu_id'    => $item['menu_id'],
                    'quantity'   => $item['quantity'],
                    'total_price'=> $menu->price * $item['quantity'],
                    'pickup_time'=> $validated['pickup_time'],
                    'notes'      => $item['notes'] ?? null,
                    'status'     => 'pending',
                ]);

                $menu->decrement('stock', $item['quantity']);

                if ($menu->fresh()->stock <= 0) {
                    $menu->update(['is_available' => false]);
                }
            }

            DB::commit();

            $label = $validated['pickup_time'] === 'istirahat_1' ? 'Istirahat 1 (10:00–10:30)' : 'Istirahat 2 (12:00–12:30)';
            return redirect()->route('customer.myOrders')
                ->with('success', count($validated['items']) . ' pesanan berhasil! Saldo berkurang Rp ' . number_format($totalBatch, 0, ',', '.') . '. Ambil saat ' . $label);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function myOrders(Request $request)
    {
        $query = Order::with('menu')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'preparing', 'ready']);
        
        // Filter by pickup time if provided
        if ($request->filled('pickup_time')) {
            $query->where('pickup_time', $request->pickup_time);
        }
        
        $orders = $query->latest()
            ->paginate(10)
            ->withQueryString();
        
        return view('customer.order.my-orders', compact('orders'));
    }

    public function history(Request $request)
    {
        $query = Order::with('menu')
            ->where('user_id', auth()->id())
            ->where('status', 'completed');
        
        // Filter by pickup time if provided
        if ($request->filled('pickup_time')) {
            $query->where('pickup_time', $request->pickup_time);
        }
        
        $orders = $query->latest()
            ->paginate(15)
            ->withQueryString();
        
        return view('customer.order.history', compact('orders'));
    }
}
