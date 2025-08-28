<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Auth\Events\Verified;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (bisa view-only atau edit).
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Tampilkan form edit profil.
     */
public function edit(Request $request): View
{
    return view('profile.edit', [
        'user' => $request->user(),
    ]);
}

    /**
     * Simpan perubahan data profil user (untuk AJAX dan Redirect).
     */
    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        // Validasi data dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // Simpan data lama untuk pengecekan
        $originalData = $user->only(['name', 'email', 'phone', 'address']);

        // Isi data dari request
        $user->fill($request->only('name', 'email', 'phone', 'address'));

        // Cek apakah email berubah
        $emailChanged = $user->isDirty('email');

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        // Simpan ke database
        $user->save();

       

        // Ambil data baru yang disimpan
        $updatedData = $user->only(['name', 'email', 'phone', 'address', 'is_active', 'updated_at']);

        // Jika request AJAX (dari JS), kirim JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $emailChanged 
                    ? 'Profil berhasil diperbarui! Silakan verifikasi email baru Anda.' 
                    : 'Profil berhasil diperbarui!',
                'data' => $updatedData,
                'email_changed' => $emailChanged,
            ], 200);
        }

        // Jika bukan AJAX, redirect seperti biasa
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Ubah password user (hanya untuk AJAX).
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'different:current_password', // Harus berbeda dari password lama
            ],
        ]);

        $user = $request->user();

        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => [
                    'current_password' => ['Password saat ini salah.']
                ]
            ], 422);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password berhasil diubah!'
        ], 200);
    }

    /**
     * Hapus akun user secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun Anda telah dihapus.');
    }
}