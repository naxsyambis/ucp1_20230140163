<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    {{-- Header --}}
                    <div class="flex items-center gap-3 mb-8 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <a href="{{ route('kategori.index') }}" class="p-2 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Detail Kategori</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Informasi lengkap tentang kategori ini</p>
                        </div>
                    </div>

                    {{-- Informasi Detail (Card Style) --}}
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6 mb-8 border border-gray-100 dark:border-gray-700">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Kategori</label>
                                <p class="mt-1 text-xl font-bold text-gray-900 dark:text-white">{{ $kategori->name }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Produk yang Terhubung</label>
                                <div class="mt-2">
                                    @if($kategori->product)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            {{ $kategori->product->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada produk terkait</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Kategori
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>