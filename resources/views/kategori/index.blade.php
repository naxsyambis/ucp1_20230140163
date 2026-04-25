<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Bagian Header: Judul dan Tombol Tambah --}}
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Kategori List</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar data kategori produk Anda</p>
                        </div>
                        {{-- Link ke halaman form tambah kategori --}}
                        <a href="{{ route('kategori.create') }}" 
                        class="px-4 py-2 bg-black hover:bg-gray-800 text-white text-sm font-semibold rounded-lg transition">
                            + Add Category
                        </a>
                    </div>

                    {{-- Flash Message: Muncul jika ada session('success') dari Controller --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-300 rounded shadow-sm text-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    {{-- Wrapper Tabel dengan scroll horizontal untuk tampilan mobile --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-8">#</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Kategori</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terkait Produk</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                {{-- Looping Data: Menggunakan @forelse untuk menangani data kosong --}}
                                @forelse ($kategoris as $kategori)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">
                                            {{ $loop->iteration }} {{-- Penomoran otomatis --}}
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-semibold">
                                            {{ $kategori->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- Menghitung jumlah produk yang terhubung ke kategori ini --}}
                                            {{ $kategori->products->count() }} Produk
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            {{-- Link Edit --}}
                                            <a href="{{ route('kategori.edit', $kategori) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Edit</a>
                                            
                                            {{-- Form Hapus: Menggunakan metode DELETE --}}
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium" onclick="return confirm('Yakin ingin menghapus?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tampilan jika tabel kosong --}}
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-500">Belum ada data kategori.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>