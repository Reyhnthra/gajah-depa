<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPengaturanController extends Controller
{
    /**
     * Menampilkan Halaman Pengaturan Profil & Cabang Admin
     */
    public function index()
    {
        $user = Auth::user();
        $cabang = $user->id_cabang ? DB::table('cabang')->where('id', $user->id_cabang)->first() : null;

        return view('admin.pengaturan', compact('user', 'cabang'));
    }

    /**
     * Menyimpan Perubahan Pengaturan Profil & Cabang Admin
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'         => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'password'      => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'no_rekening'   => 'nullable|string|max:255',
            'no_whatsapp'   => 'nullable|string|max:30',
            'alamat'        => 'nullable|string',
        ], [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'email.required'         => 'Alamat email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email tersebut sudah digunakan oleh akun lain.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'password.min'           => 'Kata sandi minimal harus 8 karakter.',
            'password.regex'         => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $updateUserData = [
            'nama'          => $request->nama,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'updated_at'    => now(),
        ];

        if ($request->filled('password')) {
            $updateUserData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $user->id)->update($updateUserData);

        // Jika admin terikat dengan suatu cabang, perbarui juga informasi kontak/rekening cabang jika diisi
        if ($user->id_cabang) {
            $updateCabangData = [];
            if ($request->has('no_rekening')) {
                $updateCabangData['no_rekening'] = $request->no_rekening;
            }
            if ($request->has('no_whatsapp')) {
                $updateCabangData['no_whatsapp'] = $request->no_whatsapp;
            }
            if ($request->has('alamat')) {
                $updateCabangData['alamat'] = $request->alamat;
            }

            if (!empty($updateCabangData)) {
                DB::table('cabang')->where('id', $user->id_cabang)->update($updateCabangData);
            }
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan profil dan akun berhasil diperbarui.');
    }
}

