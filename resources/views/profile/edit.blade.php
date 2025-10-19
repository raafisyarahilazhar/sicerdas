@extends('layout.main')

@section('content')
<main class="container mx-auto p-6 lg:p-8">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-green-700">Profil Akun</h2>
        <p class="text-gray-600 max-w-3xl mt-1">
            Kelola informasi pribadi, keamanan kata sandi, dan preferensi akun Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Informasi Profil (2 kolom) --}}
        <section class="lg:col-span-2 p-6 rounded-lg shadow-sm border">
            <h3 class="text-xl font-bold border-l-4 border-green-700 text-green-700 pl-4 mb-5">
                INFORMASI PROFIL
            </h3>
            <div class="max-w-2xl text-justify">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        {{-- Ubah Kata Sandi (1 kolom) --}}
        <section class="p-6 rounded-lg shadow-sm border">
            <h3 class="text-xl font-bold border-l-4 border-green-700 text-green-700 pl-4 mb-5">
                KEAMANAN (KATA SANDI)
            </h3>
            <div class="max-w-lg text-justify">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        {{-- Demografi Warga (baru) --}}
        <section class="lg:col-span-3 p-6 rounded-lg shadow-sm border">
            @include('profile.partials.demography-form')
        </section>


        {{-- Hapus Akun (full width) --}}
        <section class="lg:col-span-3 p-6 rounded-lg shadow-sm border">
            <h3 class="text-xl font-bold border-l-4 border-green-700 text-green-700 pl-4 mb-5">
                HAPUS AKUN
            </h3>
            <div class="max-w-xl text-justify">
                @include('profile.partials.delete-user-form')
            </div>
        </section>

    </div>
</main>
@endsection
