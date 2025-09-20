@extends('layout.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Edit Data Pengguna</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        
        <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Field Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="input-style">
            </div>
            
            {{-- Field NIK --}}
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik', $user->nik) }}"
                       class="input-style">
            </div>

            {{-- Field Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="input-style">
            </div>
            
            {{-- Field Nomor Telepon --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                       class="input-style">
            </div>
            
            {{-- Field Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" class="input-style">{{ old('alamat', $user->alamat) }}</textarea>
            </div>
            
            {{-- Field RW --}}
            <div>
                <label for="rw_id" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                <select name="rw_id" id="rw_id" class="input-style">
                    <option value="">-- Pilih RW --</option>
                    @foreach($rws as $rw)
                        <option value="{{ $rw->id }}" @selected(old('rw_id', $user->rw_id) == $rw->id)>
                            {{ $rw->nomor }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            {{-- Field RT --}}
            <div>
                <label for="rt_id" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                <select name="rt_id" id="rt_id" class="input-style">
                    <option value="">-- Pilih RT --</option>
                    @foreach($rts as $rt)
                        <option value="{{ $rt->id }}" @selected(old('rt_id', $user->rt_id) == $rt->id)>
                            {{ $rt->nomor }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Field Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Peran (Role)</label>
                <select name="role" id="role" class="input-style">
                    <option value="warga" @selected(old('role', $user->role) == 'warga')>Warga</option>
                    <option value="rt" @selected(old('role', $user->role) == 'rt')>RT</option>
                    <option value="rw" @selected(old('role', $user->role) == 'rw')>RW</option>
                    <option value="kades" @selected(old('role', $user->role) == 'kades')>Kades</option>
                    <option value="operator" @selected(old('role', $user->role) == 'operator')>Operator</option>
                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                </select>
            </div>

            {{-- Tombol Update --}}
            <div class="flex justify-end pt-4">
                <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg mr-4 hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</main>

{{-- Definisikan style input di satu tempat agar mudah diubah --}}
<style>
    .input-style {
        display: block;
        width: 100%;
        padding: 0.5rem 0.75rem;
        background-color: white;
        border: 1px solid #D1D5DB; /* border-gray-300 */
        border-radius: 0.375rem; /* rounded-md */
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
    .input-style:focus {
        outline: none;
        --tw-ring-color: #16a34a; /* ring-green-600 */
        --tw-ring-shadow: 0 0 0 2px var(--tw-ring-color);
        box-shadow: var(--tw-ring-shadow);
        border-color: #16a34a; /* border-green-600 */
    }
</style>
@endsection