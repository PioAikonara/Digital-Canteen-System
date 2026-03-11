<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\SuperAdmin\DashboardController as SaDashboard;
use App\Http\Controllers\SuperAdmin\UserController as SaUserController;
use App\Http\Controllers\SuperAdmin\AdminController as SaAdminController;
use App\Http\Controllers\SuperAdmin\TopUpController as SaTopUpController;
use App\Http\Controllers\SuperAdmin\ReportController as SaReportController;
use App\Http\Controllers\SuperAdmin\CategoryController as SaCategoryController;
use App\Http\Controllers\SuperAdmin\OrderMonitorController as SaOrderController;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $adminId = auth()->id();

        $totalMenus      = Menu::where('admin_id', $adminId)->count();
        $availableMenus  = Menu::where('admin_id', $adminId)->where('is_available', true)->count();
        $lowStockMenus   = Menu::where('admin_id', $adminId)->where('stock', '>', 0)->where('stock', '<=', 5)->count();

        $todayOrders     = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->whereDate('created_at', today())->count();
        $pendingCount    = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'pending')->count();
        $preparingCount  = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'preparing')->count();
        $readyCount      = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))->where('status', 'ready')->count();

        $totalCustomers  = User::where('role', 'customer')->count();

        $todayRevenue    = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))
                              ->whereDate('created_at', today())
                              ->where('status', 'completed')
                              ->sum('total_price');
        $totalRevenue    = Order::whereHas('menu', fn($q) => $q->where('admin_id', $adminId))
                              ->where('status', 'completed')
                              ->sum('total_price');

        $recentOrders    = Order::with(['user', 'menu'])
                              ->whereHas('menu', fn($q) => $q->where('admin_id', $adminId))
                              ->latest()
                              ->take(10)
                              ->get();

        $dashboardMenus  = Menu::where('admin_id', $adminId)->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalMenus', 'availableMenus', 'lowStockMenus',
            'todayOrders', 'pendingCount', 'preparingCount', 'readyCount',
            'totalCustomers', 'todayRevenue', 'totalRevenue',
            'recentOrders', 'dashboardMenus'
        ));
    })->name('dashboard');
    
    // Menu Management
    Route::resource('menus', MenuController::class);
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // User/Customer Management (by admin)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        $menus = Menu::where('is_available', true)->where('stock', '>', 0)->latest()->take(6)->get();
        $activeOrders = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->count();
        return view('customer.dashboard', compact('menus', 'activeOrders'));
    })->name('customer.dashboard');
    
    // Customer Order Routes
    Route::get('/customer/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::post('/customer/orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
    Route::post('/customer/orders/batch', [CustomerOrderController::class, 'storeBatch'])->name('customer.orders.storeBatch');
    Route::get('/customer/my-orders', [CustomerOrderController::class, 'myOrders'])->name('customer.myOrders');
    Route::get('/customer/history', [CustomerOrderController::class, 'history'])->name('customer.history');
});

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SaDashboard::class, 'index'])->name('dashboard');

    // Users (customers)
    Route::resource('users', SaUserController::class);

    // Admins (kantin staff)
    Route::get('/admins', [SaAdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [SaAdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [SaAdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{admin}/edit', [SaAdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{admin}', [SaAdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [SaAdminController::class, 'destroy'])->name('admins.destroy');

    // Top Up
    Route::get('/topup', [SaTopUpController::class, 'index'])->name('topup.index');
    Route::post('/topup', [SaTopUpController::class, 'store'])->name('topup.store');

    // Reports
    Route::get('/reports', [SaReportController::class, 'index'])->name('reports.index');

    // Categories
    Route::get('/categories', [SaCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [SaCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [SaCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [SaCategoryController::class, 'destroy'])->name('categories.destroy');

    // Order Monitor
    Route::get('/orders', [SaOrderController::class, 'index'])->name('orders.index');
});

require __DIR__.'/auth.php';
