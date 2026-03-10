<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->get('search', '');
        $topUps  = TopUp::with(['user', 'processedBy'])
            ->when($search, fn($q) => $q->whereHas('user',
                fn($u) => $u->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $users = User::where('role', 'customer')->orderBy('name')->get();

        $totalTopUp = TopUp::sum('amount');

        return view('superadmin.topup.index', compact('topUps', 'users', 'search', 'totalTopUp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount'  => ['required', 'integer', 'min:1000', 'max:10000000'],
            'notes'   => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::where('role', 'customer')->findOrFail($request->user_id);
        $user->increment('balance', $request->amount);

        TopUp::create([
            'user_id'      => $user->id,
            'processed_by' => auth()->id(),
            'amount'       => $request->amount,
            'notes'        => $request->notes,
        ]);

        return redirect()->route('superadmin.topup.index')
            ->with('success', 'Top up Rp ' . number_format($request->amount, 0, ',', '.') . ' untuk ' . $user->name . ' berhasil!');
    }
}
