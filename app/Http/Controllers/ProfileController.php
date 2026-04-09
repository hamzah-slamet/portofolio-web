<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'user_id'          => 'nullable|string|max:50|unique:users,user_id,' . $user->id,
            'umur'             => 'nullable|integer|min:1|max:120',
            'alamat'           => 'nullable|string|max:500',
            'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tempat_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:Laki-laki,Perempuan',
            'agama'            => 'nullable|string|max:50',
            'kewarganegaraan'  => 'nullable|string|max:100',
            'status_pernikahan'=> 'nullable|in:Belum Menikah,Menikah,Cerai',
            'role' => 'nullable|in:admin,user,editor',
            'tentang'    => 'nullable|string|max:1000',
            'status_akun'=> 'nullable|in:aktif,nonaktif',
        ]);

        $data = $request->only([
            'name', 'email', 'user_id', 'umur', 'alamat',
            'role', 'tentang', 'status_akun',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
            'agama', 'kewarganegaraan', 'status_pernikahan',
        ]);
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
