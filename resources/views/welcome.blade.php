@extends('layout.main')

@section('content')
        <main class="container mx-auto p-6 lg:p-8">
        <div class="my-4">
             <p class="text-green-600 max-w-4xl text-base leading-relaxed mb-8">
                Adobe XD, or Experience Design, is built for today's UX/UI designers, with intuitive tools that eliminate speed bumps and make everyday tasks effortless. Get started with free UI kits, icon sets, and everything you need to create unique user experiences.
            </p>
            <div>
                <img src="{{ asset('images/header.jpg') }}" alt="Team discussing work" class="w-full h-auto object-cover rounded-xl shadow-md">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">

            <div class="lg:col-span-2 space-y-10">

                <section class="p-6 rounded-lg shadow-sm space-y-4 text-green-700 text-justify border">
                    <h3 class="text-xl font-bold border-l-4 border-green-700 text-green-700 pl-4 mb-5">VIDEO</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <img src="https://placehold.co/300x200/ddd/333?text=Video+Thumbnail+1" alt="Video thumbnail 1" class="w-full h-auto object-cover rounded-lg shadow">
                        </div>
                        <div>
                            <img src="https://placehold.co/300x200/ddd/333?text=Video+Thumbnail+2" alt="Video thumbnail 2" class="w-full h-auto object-cover rounded-lg shadow">
                        </div>
                    </div>
                     <div class="text-right mt-4">
                        <a href="#" class="inline-block bg-green-700 text-white px-4 py-2 text-sm rounded-md hover:bg-green-800 transition-colors">Selengkapnya ></a>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl text-green-700 font-bold border-l-4 border-green-700 pl-4 mb-5">PENGUMUMAN</h3>
                    <div class="p-6 rounded-lg shadow-sm space-y-4 text-green-700 text-justify border">
                        <p>Adobe XD, or Experience Design, is built for today's UX/UI designers, with intuitive tools that eliminate speed bumps and make everyday tasks effortless. Get started with free UI kits, icon sets, and everything you need to create unique user experiences.</p>
                        <hr>
                        <p>Adobe XD, or Experience Design, is built for today's UX/UI designers, with intuitive tools that eliminate speed bumps and make everyday tasks effortless. Get started with free UI kits, icon sets, and everything you need to create unique user experiences.</p>
                        <div class="text-right border-t pt-2">
                            <a href="#" class="inline-block bg-green-700 text-white px-5 py-2 rounded-md hover:bg-green-800 transition-all duration-300 transform hover:scale-105">Selengkapnya ></a>
                        </div>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl text-green-700 font-bold border-l-4 border-green-700 pl-4 mb-5">BERITA</h3>
                    <div class="p-6 rounded-lg shadow-sm space-y-4 text-green-700 text-justify border">
                        @forelse ($berita as $item)
                            <a href="berita/{{ $item->id }}" class="block hover:bg-green-50 rounded-lg transition-colors">
                                <p>{!! Str::limit($item->content, 60) !!}</p>
                                <hr class="my-5">
                            </a>
                        @empty
                            <p>Belum ada berita terpublikasi</p>
                        @endforelse
                        <div class="text-right">
                            <a href="/news" class="inline-block bg-green-700 text-white px-5 py-2 rounded-md hover:bg-green-800 transition-all duration-300 transform hover:scale-105">Selengkapnya ></a>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <div class="bg-white rounded-lg overflow-hidden shadow-sm border">
                    <h4 class="font-bold bg-green-700 text-white p-4 text-lg">Kategori</h4>
                    <div class="p-4 space-y-2">
                        <a href="#" class="block text-center bg-green-600 text-white p-3 rounded-md hover:bg-green-700 transition-colors font-medium">Kependudukan dan catatan sipil</a>
                        <a href="#" class="block text-center bg-green-600 text-white p-3 rounded-md hover:bg-green-700 transition-colors font-medium">Sosial Dan Ekonomi</a>
                        <a href="#" class="block text-center bg-green-600 text-white p-3 rounded-md hover:bg-green-700 transition-colors font-medium">Usaha Dan Ekonomi</a>
                        <a href="#" class="block text-center bg-green-600 text-white p-3 rounded-md hover:bg-green-700 transition-colors font-medium">Pertanahan dan Properti</a>
                    </div>
                </div>

                @guest
                    <div class="space-y-3">
                        <a href="{{ route('applications.create') }}" class="inline-flex items-center justify-center w-full px-6 py-4 text-green-700 text-lg font-bold rounded-lg hover:bg-green-100 transition-all duration-300 transform hover:scale-105 shadow-md">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                            BUAT SURAT
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="space-y-3">
                        <a href="{{ route('tracking.index') }}" class="flex items-center space-x-3 w-full text-left bg-white border-2 border-green-700 text-green-700 p-3 rounded-lg hover:bg-green-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="font-semibold">TRACKING STATUS PERMOHONAN</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 w-full text-left bg-white border-2 border-green-700 text-green-700 p-3 rounded-lg hover:bg-green-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                             <span class="font-semibold">CETAK SURAT ANDA</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 w-full text-left bg-white border-2 border-green-700 text-green-700 p-3 rounded-lg hover:bg-green-50 transition-colors">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                           <span class="font-semibold">DAFTAR SURAT YANG DIBUAT</span>
                        </a>
                    </div>
                @endauth
                
                <div class="bg-white rounded-lg overflow-hidden shadow-sm border">
                    <h4 class="font-bold bg-green-700 text-white p-4 text-lg">FAQ</h4>
                    <div class="p-4 space-y-3 text-gray-600">
                        <p>Adobe XD, or Experience Design, is built for today's UX/UI designers, with intuitive tools that eliminate speed bumps...</p>
                        <hr>
                         <p>Adobe XD, or Experience Design, is built for today's UX/UI designers, with intuitive tools that eliminate speed bumps...</p>
                    </div>
                     <div class="p-4 text-right border-t mt-2">
                        <a href="#" class="inline-block bg-green-700 text-white px-4 py-2 text-sm rounded-md hover:bg-green-800 transition-colors">Selengkapnya ></a>
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection