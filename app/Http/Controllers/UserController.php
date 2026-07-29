<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        // Paginasi 6 baris agar muat presisi 1 viewport tanpa memicu scrollbar browser luar
        $users = User::with(['role', 'direktorat'])
            ->latest('id')
            ->paginate(8);

        $roles = Role::orderBy('id', 'asc')->get();
        $direktorats = Direktorat::orderBy('nama', 'asc')->get();

        return view('users.index', compact('users', 'roles', 'direktorats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8'],
            'role_id'       => ['required', 'exists:roles,id'],
            'direktorat_id' => ['nullable', 'required_if:role_id,2', 'exists:direktorats,id'],
        ], [
            'direktorat_id.required_if' => 'Direktorat wajib dipilih untuk role Admin Direktorat.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->getKey())],
            'password'      => ['nullable', 'string', 'min:8'],
            'role_id'       => ['required', 'exists:roles,id'],
            'direktorat_id' => ['nullable', 'required_if:role_id,2', 'exists:direktorats,id'],
        ], [
            'direktorat_id.required_if' => 'Direktorat wajib dipilih untuk role Admin Direktorat.',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        if ($currentUser->getKey() === $user->getKey()) {
            return redirect()->back()
                ->with('error', 'Tindakan ditolak: Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}