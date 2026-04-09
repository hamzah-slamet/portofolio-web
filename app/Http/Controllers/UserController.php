<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // $totalVerified   = User::whereNotNull('email_verified_at')->count();
        // $totalUnverified = User::whereNull('email_verified_at')->count();
        $totalAktif = User::where('status_akun', 'aktif')->count();
        $totalBelumLengkap = User::where(function($query) {
            $query->whereNull('alamat')
                ->orWhereNull('umur')
                ->orWhereNull('tempat_lahir')
                ->orWhereNull('tanggal_lahir')
                ->orWhereNull('jenis_kelamin')
                ->orWhereNull('agama')
                ->orWhereNull('kewarganegaraan')
                ->orWhereNull('status_pernikahan')
                ->orWhere('alamat', '')
                ->orWhere('kewarganegaraan', '');
        })->count();
        $authId = Auth::id();
        $users = User::orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$authId])
            ->orderByRaw("CASE
                WHEN alamat IS NOT NULL AND alamat != ''
                AND umur IS NOT NULL
                AND tempat_lahir IS NOT NULL AND tempat_lahir != ''
                AND tanggal_lahir IS NOT NULL
                AND jenis_kelamin IS NOT NULL AND jenis_kelamin != ''
                AND agama IS NOT NULL AND agama != ''
                AND kewarganegaraan IS NOT NULL AND kewarganegaraan != ''
                AND status_pernikahan IS NOT NULL AND status_pernikahan != ''
                THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.index', compact('users', 'totalAktif', 'totalBelumLengkap'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',
            'user_id'          => 'nullable|string|max:50|unique:users,user_id',
            'umur'             => 'nullable|integer|min:1|max:120',
            'alamat'           => 'nullable|string|max:500',
            'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'role'             => 'nullable|in:admin,user,editor',
            'tempat_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'agama'            => 'nullable|string|max:50',
            'kewarganegaraan'  => 'nullable|string|max:100',
            'status_pernikahan'=> 'nullable|in:Belum Menikah,Menikah,Cerai',
            'tentang'          => 'nullable|string|max:1000',
            'status_akun'      => 'nullable|in:aktif,nonaktif',
        ], [
            'email.unique' => 'Email telah di pakai. Silakan gunakan email lain.',
            'user_id.unique' => 'User ID sudah terdaftar. Gunakan User ID yang berbeda.',
        ]);

        $data = $request->only([
            'name', 'email', 'user_id', 'umur', 'alamat',
            'role', 'tentang', 'status_akun',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
            'agama', 'kewarganegaraan', 'status_pernikahan',
        ]);

        $data['password'] = Hash::make($request->password);
        $data['status_akun'] = $request->status_akun ?? 'aktif';

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan!');
    }
    public function update(Request $request, User $user)
    {
        // Tidak boleh edit diri sendiri di halaman ini
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Gunakan halaman Profil Saya untuk mengedit akun Anda sendiri.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'user_id'     => 'nullable|string|max:50|unique:users,user_id,' . $user->id,
            'umur'        => 'nullable|integer|min:1|max:120',
            'alamat'      => 'nullable|string|max:500',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'role'             => 'nullable|in:admin,user,editor',
            'tempat_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'agama'            => 'nullable|string|max:50',
            'kewarganegaraan'  => 'nullable|string|max:100',
            'status_pernikahan'=> 'nullable|in:Belum Menikah,Menikah,Cerai',
            'tentang'    => 'nullable|string|max:1000',
            'status_akun'=> 'nullable|in:aktif,nonaktif',
        ], [
            'email.unique' => 'Email telah di pakai. Silakan gunakan email lain.',
            'user_id.unique' => 'User ID sudah terdaftar. Gunakan User ID yang berbeda.',
        ]);

        $data = $request->only([
            'name', 'email', 'user_id', 'umur', 'alamat',
            'role', 'tentang', 'status_akun', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'kewarganegaraan', 'status_pernikahan',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Tidak boleh hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
