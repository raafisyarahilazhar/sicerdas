<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - SICERDAS</title>
    {{-- Memuat Tailwind CSS dari CDN --}}
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-white">

    <main class="flex flex-col md:flex-row min-h-screen">
        
        <div class="w-full md:w-3/5 bg-white p-8 sm:p-12 flex flex-col justify-center items-center">
            <div class="w-full max-w-md">
                <h1 class="text-3xl md:text-4xl font-bold text-green-700 text-center mb-4">
                    Create Account
                </h1>
                
                {{-- Opsi Social Media (Opsional) --}}
                <div class="flex justify-center space-x-4 mb-8">
                    {{-- ikon-ikon social media --}}
                </div>

                {{-- Form Utama --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        </span>
                        <input type="text" name="name" placeholder="Nama Lengkap (Username)" class="input-field" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 4a1 1 0 100 2h4a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                        </span>
                        <input type="text" name="nik" placeholder="NIK" class="input-field" required>
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                        </span>
                        <select name="rw_id" class="input-field" required>
                            <option value="" selected disabled>-- Pilih RW --</option>
                            @foreach($rws as $rw)
                                <option value="{{ $rw->id }}">{{ $rw->name }}</option>
                            @endforeach
                        </select>
                        @error('rw_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                        </span>
                        <select name="rt_id" class="input-field" required>
                            <option value="" selected disabled>-- Pilih RT --</option>
                            @foreach($rts as $rt)
                                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                            @endforeach
                        </select>
                        @error('rt_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                        </span>
                        <input type="email" name="email" placeholder="Email" class="input-field" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <input type="password" name="password" placeholder="Password" class="input-field" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="input-field" required>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 4a1 1 0 100 2h4a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                        </span>
                        <input type="tel" inputmode="numeric" pattern="08[0-9]{8,13}" name="phone" placeholder="Nomor Hp / Whatsapp" class="input-field" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                        </span>
                        <textarea name="alamat" cols="30" rows="3" placeholder="Masukan Alamat Lengkap" class="input-field" required></textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-green-600 text-white rounded-full py-3 font-semibold uppercase hover:bg-green-700 transition-colors duration-300">
                            Sign Up
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full md:w-2/5 bg-green-600 text-white p-12 flex flex-col justify-center items-center text-center space-y-6">
            <h2 class="text-4xl font-bold">Welcome Back!</h2>
            <p class="px-4">
                Sudah punya akun? Silakan masuk untuk mengakses layanan kami.
            </p>
            <a href="{{ route('login') }}" class="inline-block border-2 border-white rounded-full px-12 py-3 font-semibold uppercase hover:bg-white hover:text-green-600 transition-colors duration-300">
                Sign In
            </a>
        </div>
    </main>

    {{-- Style Tambahan untuk mengurangi repetisi kelas --}}
    <style>
        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem; /* w-12 */
            height: 3rem; /* h-12 */
            border-width: 2px;
            border-color: #D1D5DB; /* border-gray-300 */
            border-radius: 9999px; /* rounded-full */
            color: #15803d; /* text-green-700 */
            transition: background-color 0.3s;
        }
        .social-icon:hover {
            background-color: #F9FAFB; /* hover:bg-gray-50 */
        }
        .input-icon {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            display: flex;
            align-items: center;
            padding-left: 1rem; /* pl-4 */
            color: #9CA3AF; /* text-gray-400 */
        }
        .input-field {
            width: 100%;
            background-color: #F3F4F6; /* bg-gray-100 */
            border: none;
            border-radius: 0.5rem; /* rounded-lg */
            padding-top: 0.75rem; /* py-3 */
            padding-bottom: 0.75rem; /* py-3 */
            padding-left: 3rem; /* pl-12 */
            padding-right: 1rem; /* pr-4 */
        }
        .input-field:focus {
            outline: none;
            --tw-ring-color: #22c55e; /* ring-green-500 */
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }
    </style>

</body>
</html>
