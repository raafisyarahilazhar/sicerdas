<section>
    <header class="mb-4">
        <h2 class="text-2xl font-bold text-green-800">{{ __('Informasi Profil') }}</h2>
        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi akun dan data kependudukan Anda.
        </p>
    </header>

    {{-- form verifikasi email (default Jetstream/Breeze) --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')
        <input type="hidden" name="_section" value="profile">
        {{-- Data Akun (users) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="input-style bg-white text-gray-900"
                       placeholder="Nama sesuai KTP" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- NIK (users.nik) --}}
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}"
                       class="input-style bg-white text-gray-900"
                       placeholder="Contoh: 3217xxxxxxxxxxxx">
                @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                       class="input-style bg-white text-gray-900"
                       placeholder="nama@email.com">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="text-sm text-gray-800 mt-2">
                        Email Anda belum terverifikasi.
                        <button form="send-verification"
                                class="underline text-green-700 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 rounded">
                            Klik untuk kirim ulang tautan verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Tautan verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                @endif
            </div>

            {{-- Telepon (users.phone) --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="input-style bg-white text-gray-900"
                       placeholder="Contoh: 0812xxxxxxx">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- RW --}}
            <div>
                <label for="rw_id" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                <select id="rw_id" name="rw_id" class="input-style bg-white text-gray-900">
                    <option value="">Pilih RW</option>
                    @foreach($rws as $rw)
                        <option value="{{ $rw->id }}" {{ (old('rw_id', $user->rw_id) == $rw->id) ? 'selected' : '' }}>
                            RW {{ $rw->id }}
                        </option>
                    @endforeach
                </select>
                @error('rw_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- RT --}}
            <div>
                <label for="rt_id" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                <select id="rt_id" name="rt_id" class="input-style bg-white text-gray-900">
                    <option value="">Pilih RT</option>
                    @foreach($rts as $rt)
                        <option value="{{ $rt->id }}" {{ (old('rt_id', $user->rt_id) == $rt->id) ? 'selected' : '' }}>
                            RT {{ $rt->id }} — RW {{ $rt->rw?->id }}
                        </option>
                    @endforeach
                </select>
                @error('rt_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Alamat (users.alamat) --}}
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" class="input-style bg-white text-gray-900"
                      placeholder="Alamat domisili lengkap">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Data Kependudukan Tambahan (residents) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Tgl Lahir --}}
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" id="birth_date" name="birth_date"
                       value="{{ old('birth_date', optional($user->resident)->birth_date?->format('Y-m-d')) }}"
                       class="input-style bg-white text-gray-900">
                @error('birth_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Gender --}}
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select id="gender" name="gender" class="input-style bg-white text-gray-900">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('gender', optional($user->resident)->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', optional($user->resident)->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- No. KK --}}
            <div>
                <label for="kk_number" class="block text-sm font-medium text-gray-700 mb-1">No. KK</label>
                <input type="text" id="kk_number" name="kk_number"
                       value="{{ old('kk_number', optional($user->resident)->kk_number) }}"
                       class="input-style bg-white text-gray-900"
                       placeholder="Nomor Kartu Keluarga">
                @error('kk_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">{{ __('Simpan Perubahan') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show:true }" x-show="show" x-transition x-init="setTimeout(()=>show=false,2000)"
                   class="text-sm text-gray-700">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
