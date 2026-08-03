@extends('layouts.app')

@section('content')
<div x-data="{ 
    openCreate: false, 
    openEdit: false, 
    showPasswordCreate: false,
    showPasswordEdit: false,
    editData: { id: '', name: '', email: '', role_id: '', direktorat_id: '' } 
}" class="flex h-[calc(100vh-88px-2.5rem)] flex-col justify-between overflow-hidden space-y-4">

    {{-- System Alerts --}}
    @if(session('success'))
        <div class="shrink-0 rounded-xl border border-emerald-300 bg-[#DDF6D2] px-4 py-2.5 text-xs font-medium text-emerald-900 shadow-sm flex items-center gap-2">
            <svg class="h-4 w-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="shrink-0 rounded-xl border border-rose-300 bg-rose-50 px-4 py-2.5 text-xs font-medium text-rose-800 shadow-sm flex items-center gap-2">
            <svg class="h-4 w-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="shrink-0 rounded-xl border border-rose-300 bg-rose-50 px-4 py-2.5 text-xs text-rose-800 shadow-sm">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD 1: Header Modul --}}
    <div class="shrink-0 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            {{-- Icon Container Hijau HORTIKU --}}
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#DDF6D2]">
                <svg class="h-6 w-6" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_512_1489)">
                        <path d="M22.6666 28V25.3333C22.6666 23.9188 22.1047 22.5623 21.1045 21.5621C20.1043 20.5619 18.7477 20 17.3333 20H6.66659C5.2521 20 3.89554 20.5619 2.89535 21.5621C1.89516 22.5623 1.33325 23.9188 1.33325 25.3333V28M30.6666 28V25.3333C30.6657 24.1516 30.2724 23.0037 29.5484 22.0698C28.8244 21.1358 27.8108 20.4688 26.6666 20.1733M21.3333 4.17333C22.4805 4.46707 23.4973 5.13427 24.2234 6.06975C24.9496 7.00523 25.3437 8.15577 25.3437 9.34C25.3437 10.5242 24.9496 11.6748 24.2234 12.6103C23.4973 13.5457 22.4805 14.2129 21.3333 14.5067M17.3333 9.33333C17.3333 12.2789 14.9454 14.6667 11.9999 14.6667C9.0544 14.6667 6.66659 12.2789 6.66659 9.33333C6.66659 6.38781 9.0544 4 11.9999 4C14.9454 4 17.3333 6.38781 17.3333 9.33333Z" stroke="#165C27" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_512_1489">
                            <rect width="32" height="32" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola akun Super Admin, Admin Direktorat, dan User Sistem HORTIKU.</p>
            </div>
        </div>
        <button @click="openCreate = true" class="inline-flex items-center gap-2 rounded-xl bg-[#165C27] px-5 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-[#114B1F] transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah User Baru
        </button>
    </div>

    {{-- CARD 2: Data Table & Paginasi --}}
    <div class="flex flex-1 min-h-0 flex-col justify-between overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        
        {{-- Area Scroll Tabel Internal --}}
        <div class="flex-1 overflow-y-auto">
            <table class="w-full border-collapse text-left text-xs text-slate-600">
                <thead class="sticky top-0 z-10 border-b border-slate-100 bg-slate-50/90 backdrop-blur-sm text-[11px] font-bold uppercase tracking-wider text-slate-700">
                    <tr>
                        <th class="px-6 py-3.5">Nama Lengkap</th>
                        <th class="px-6 py-3.5">Email</th>
                        <th class="px-6 py-3.5">Role Hak Akses</th>
                        <th class="px-6 py-3.5">Nama Direktorat</th>
                        <th class="px-6 py-3.5 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-3.5">
                                {{-- Monochromatic Green Capsule Pill Badges --}}
                                @if($user->role_id == 1)
                                    <span class="inline-flex items-center rounded-full bg-[#B0DB9C] px-3 py-1 text-[11px] font-medium text-emerald-950">
                                        {{ $user->role?->name ?? 'Super Admin' }}
                                    </span>
                                @elseif($user->role_id == 2)
                                    <span class="inline-flex items-center rounded-full bg-[#CAE8BD] px-3 py-1 text-[11px] font-medium text-emerald-900">
                                        {{ $user->role?->name ?? 'Admin Direktorat' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-[#DDF6D2] px-3 py-1 text-[11px] font-medium text-emerald-800">
                                        {{ $user->role?->name ?? 'User' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-slate-600">
                                {{ $user->direktorat?->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                <div class="inline-flex items-center gap-2">
                                    {{-- Outline Edit Hijau --}}
                                    <button 
                                        @click="
                                            editData = {
                                                id: '{{ $user->getKey() }}',
                                                name: '{{ addslashes($user->name) }}',
                                                email: '{{ $user->email }}',
                                                role_id: '{{ $user->role_id }}',
                                                direktorat_id: '{{ $user->direktorat_id ?? '' }}'
                                            };
                                            openEdit = true;
                                        " 
                                        class="inline-flex items-center rounded-lg border border-[#165C27] bg-[#DDF6D2]/30 px-3 py-1 text-xs font-semibold text-[#165C27] hover:bg-[#165C27] hover:text-white transition">
                                        Edit
                                    </button>

                                    {{-- Outline Hapus Merah --}}
                                    @if(auth()->id() !== $user->getKey())
                                        <form action="{{ route('users.destroy', $user->getKey()) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini secara permanen?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 bg-rose-50/40 px-3 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-600 hover:text-white transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Data pengguna belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination Bar --}}
        <div class="flex shrink-0 items-center justify-between border-t border-slate-100 bg-slate-50/50 px-6 py-3 text-xs text-slate-500">
            <div>
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
            </div>
            <div>
                @if ($users->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex rounded-lg shadow-sm">
                        @if ($users->onFirstPage())
                            <span class="inline-flex items-center rounded-l-lg border border-slate-200 bg-white px-3 py-1 text-slate-300 cursor-not-allowed">
                                &lsaquo;
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="inline-flex items-center rounded-l-lg border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-100">
                                &lsaquo;
                            </a>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="inline-flex items-center border border-[#165C27] bg-[#165C27] px-3 py-1 text-xs font-semibold text-white">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600 hover:bg-slate-100">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="inline-flex items-center rounded-r-lg border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-100">
                                &rsaquo;
                            </a>
                        @else
                            <span class="inline-flex items-center rounded-r-lg border border-slate-200 bg-white px-3 py-1 text-slate-300 cursor-not-allowed">
                                &rsaquo;
                            </span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Tambah User --}}
    <div x-show="openCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4" x-cloak>
        <div @click.away="openCreate = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Tambah Pengguna Baru</h3>
                <button @click="openCreate = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-green-600 focus:ring-green-600" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-green-600 focus:ring-green-600" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <input :type="showPasswordCreate ? 'text' : 'password'" name="password" class="w-full rounded-xl border-slate-300 px-3 py-2 pr-8 text-xs focus:border-green-600 focus:ring-green-600" required>
                            <button type="button" @click="showPasswordCreate = !showPasswordCreate" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Role Hak Akses</label>
                        <select name="role_id" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-green-600 focus:ring-green-600" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Direktorat <span class="text-slate-400 font-normal">(Wajib untuk Admin Direktorat)</span></label>
                        <select name="direktorat_id" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-green-600 focus:ring-green-600">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($direktorats as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2 border-t border-slate-100 pt-3.5">
                    <button type="button" @click="openCreate = false" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 border border-slate-200">Batal</button>
                    <button type="submit" class="rounded-xl bg-[#165C27] px-5 py-2 text-xs font-semibold text-white hover:bg-[#114B1F]">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit User --}}
    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4" x-cloak>
        <div @click.away="openEdit = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-sm font-bold text-slate-800">Perbarui Data Pengguna</h3>
                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form :action="`{{ url('users') }}/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="editData.name" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-blue-600 focus:ring-blue-600" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" x-model="editData.email" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-blue-600 focus:ring-blue-600" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Password Baru <span class="text-slate-400 font-normal">(Biarkan kosong jika tidak diubah)</span></label>
                        <div class="relative">
                            <input :type="showPasswordEdit ? 'text' : 'password'" name="password" class="w-full rounded-xl border-slate-300 px-3 py-2 pr-8 text-xs focus:border-blue-600 focus:ring-blue-600">
                            <button type="button" @click="showPasswordEdit = !showPasswordEdit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Role Hak Akses</label>
                        <select name="role_id" x-model="editData.role_id" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-blue-600 focus:ring-blue-600" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Direktorat <span class="text-slate-400 font-normal">(Wajib untuk Admin Direktorat)</span></label>
                        <select name="direktorat_id" x-model="editData.direktorat_id" class="w-full rounded-xl border-slate-300 px-3 py-2 text-xs focus:border-blue-600 focus:ring-blue-600">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($direktorats as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2 border-t border-slate-100 pt-3.5">
                    <button type="button" @click="openEdit = false" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 border border-slate-200">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-xs font-semibold text-white hover:bg-blue-700">Perbarui User</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection