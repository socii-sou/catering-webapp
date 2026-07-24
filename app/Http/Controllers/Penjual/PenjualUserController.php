<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualUserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna (Pelanggan & Penjual).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $query = User::query();

        if (!empty($role) && in_array($role, ['pelanggan', 'penjual'])) {
            $query->where('role', $role);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('created_at')->paginate(10)->withQueryString();

        $totalUsersCount = User::count();
        $pelangganCount = User::where('role', 'pelanggan')->count();
        $penjualCount = User::where('role', 'penjual')->count();
        $verifiedCount = User::whereNotNull('email_verified_at')->count();

        return view('penjual.users', compact(
            'users',
            'totalUsersCount',
            'pelangganCount',
            'penjualCount',
            'verifiedCount',
            'search',
            'role'
        ));
    }

    /**
     * Hapus pengguna dari sistem.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Pengguna \"{$userName}\" berhasil dihapus dari sistem.");
    }
}
