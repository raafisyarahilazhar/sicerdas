@php use Illuminate\Support\Str; @endphp

<section>
  <h3 class="text-xl font-bold text-green-800 mb-3">Data Demografi</h3>

  <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')
    <input type="hidden" name="_section" value="demography">
    <input type="hidden" name="name" value="{{ $user->name }}">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir</label>
        <select name="education_level" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.education_levels') as $opt)
          <option value="{{ $opt }}" {{ old('education_level', optional($user->resident)->education_level) === $opt ? 'selected' : '' }}>
            {{ Str::of($opt)->replace('_',' ')->upper() }}
          </option>
          @endforeach
        </select>
        @error('education_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
        <input name="occupation" type="text" value="{{ old('occupation', optional($user->resident)->occupation) }}"
               class="input-style bg-white text-gray-900" placeholder="Contoh: Petani, Karyawan">
        @error('occupation') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
        <select name="religion" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.religions') as $opt)
          <option value="{{ $opt }}" {{ old('religion', optional($user->resident)->religion) === $opt ? 'selected' : '' }}>
            {{ Str::of($opt)->title() }}
          </option>
          @endforeach
        </select>
        @error('religion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
        <select name="marital_status" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.marital_statuses') as $opt)
          <option value="{{ $opt }}" {{ old('marital_status', optional($user->resident)->marital_status) === $opt ? 'selected' : '' }}>
            {{ Str::of($opt)->replace('_',' ')->title() }}
          </option>
          @endforeach
        </select>
        @error('marital_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Penghasilan</label>
        <select name="income_bracket" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.income_brackets') as $opt)
          <option value="{{ $opt }}" {{ old('income_bracket', optional($user->resident)->income_bracket) === $opt ? 'selected' : '' }}>
            {{ $opt }}
          </option>
          @endforeach
        </select>
        @error('income_bracket') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
        <select name="blood_type" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.blood_types') as $opt)
          <option value="{{ $opt }}" {{ old('blood_type', optional($user->resident)->blood_type) === $opt ? 'selected' : '' }}>
            {{ $opt }}
          </option>
          @endforeach
        </select>
        @error('blood_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kewarganegaraan</label>
        <select name="citizenship" class="input-style bg-white text-gray-900">
          <option value="">Pilih</option>
          @foreach(config('demography.citizenships') as $opt)
          <option value="{{ $opt }}" {{ old('citizenship', optional($user->resident)->citizenship) === $opt ? 'selected' : '' }}>
            {{ $opt }}
          </option>
          @endforeach
        </select>
        @error('citizenship') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="disability_status" value="1"
               class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
               {{ old('disability_status', optional($user->resident)->disability_status) ? 'checked' : '' }}>
        <label class="ml-2 text-sm text-gray-900">Penyandang Disabilitas</label>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Koordinat (opsional)</label>
        <div class="grid grid-cols-2 gap-3">
          <input name="lat" type="text" value="{{ old('lat', optional($user->resident)->lat) }}"
                 class="input-style bg-white text-gray-900" placeholder="Lat">
          <input name="lng" type="text" value="{{ old('lng', optional($user->resident)->lng) }}"
                 class="input-style bg-white text-gray-900" placeholder="Lng">
        </div>
        @error('lat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        @error('lng') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

    </div>

    <div class="pt-2">
      <button type="submit" class="btn-primary">Simpan Data Demografi</button>
    </div>
  </form>
</section>
