<!DOCTYPE html>
<html lang="en">
<head>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Stocking - Inventory Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script>    
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                'stocking-yellow': '#F2C94C',
                'stocking-border': '#E0E0E0',
              },
              fontFamily: {
                sans: ['Montserrat', 'Inter', 'sans-serif'],
              }
            }
          }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; font-family: 'Montserrat', sans-serif; }
        
        [x-cloak] { 
        display: none !important; 
        }

        select {
            -webkit-appearance: none !important; /* Untuk Chrome, Safari, terbaru */
            -moz-appearance: none !important;    /* Untuk Firefox */
            appearance: none !important;         /* Standar modern */
            background-image: none !important;   /* Menghapus icon bawaan Tailwind Forms */
        }

        select::-ms-expand {
            display: none !important;
        }
        /* Custom Scrollbar */
        .table-container::-webkit-scrollbar { width: 6px; }
        .table-container::-webkit-scrollbar-thumb { background-color: #d1d5db; border-radius: 3px; }

        /* Checkbox Custom Style */
        .custom-checkbox {
            appearance: none;
            background-color: #151515;
            border: 2px solid rgba(0, 0, 0, 0.30); /* 30% Opacity */
            border-radius: 4px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .custom-checkbox:checked {
            /* Tambahkan !important untuk memaksa warna kuning muncul */
            background-color: #F2C94C !important; 
            border: 2px solid #000000 !important;
            
            /* Tambahkan ini untuk mematikan warna biru bawaan browser */
            accent-color: #F2C94C;
            appearance: none;
            -webkit-appearance: none;
        }
        .custom-checkbox:checked::after {
            content: '✔';
            position: absolute;
            color: black;
            font-size: 14px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-white" x-data="{ openModal: false, openCategoryModal: false }">

<aside class="w-64 border-r border-stocking-border flex flex-col bg-white">
    <div class="p-6">
        <h1 class="text-2xl font-bold italic tracking-tighter">
            <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/>
        </h1>
    </div>
    <nav class="flex-1 px-4 mt-4 space-y-2">
    <a href="{{ url('/admin/dashboard') }}" 
       class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200 
       {{ request()->routeIs('admin.dashboard') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
       style="{{ request()->routeIs('admin.dashboard') ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' : '' }}">
        
        <img alt="Home Icon" 
             class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'brightness-0' : 'opacity-60 grayscale' }}" 
             src="{{ asset('img/Home.png') }}"/>
        
        <span class="text-sm">Dashboard</span>
    </a>

    <a href="{{ route('admin.inventaris') }}" 
        class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200 
        {{ request()->routeIs('admin.inventaris') ? 'text-black shadow-sm' : 'text-gray-500 hover:text-black' }}"
        style="{{ request()->routeIs('admin.inventaris') 
                ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' 
                : 'background: transparent;' }}">
    <img alt="Inventaris Icon" 
         class="w-5 h-5 mr-3 {{ request()->routeIs('admin.inventaris') ? 'brightness-0' : 'opacity-60 grayscale' }}" 
         src="{{ asset('img/Inventoris.png') }}"/> 
    <span class="text-sm">Inventaris</span>
</a>
</nav>
    <div class="p-4 space-y-2">
        <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="{{ route('admin.pengaturan') }}">
            <img alt="Settings Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Settings.png') }}"/>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>
        <button onclick="openLogoutModal()" class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors font-semibold">
            <img alt="Logout Icon" class="w-5 h-5 mr-3 opacity-60 grayscale" src="{{ asset('img/Logout.png') }}"/>
            <span class="text-sm">Log Out</span>
        </button>
    </div>
</aside>

<div class="flex-1 flex flex-col overflow-hidden">
    <header class="h-16 border-b border-stocking-border bg-white flex items-center justify-between px-8">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <input class="w-full pl-4 pr-10 py-1.5 border border-stocking-border rounded-lg text-sm outline-none" placeholder="Search" type="text"/>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <img alt="Search Icon" class="w-4 h-4" src="{{ asset('img/Search.png') }}"/>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <button class="relative">
                <img alt="Notification Icon" class="w-6 h-6" src="{{ asset('img/Notifikasi.png') }}"/>
            </button>
            
        <div class="w-10 h-10 rounded-full bg-[#00DBFF] flex items-center justify-center text-white font-bold border border-white shadow-sm">
            @if(Auth::check())
                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
            @else
                A
            @endif
        </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-10 pb-10 pt-2 bg-white">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 style="color: #151515; font-size: 33.05px;" class="font-bold">Inventaris</h2>
                <p style="color: #595959;" class="text-sm">Kelola Bahan Baku Anda</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button id="btn-edit" class="hidden items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans" 
                    style="background: linear-gradient(66.3deg, #623400 0%, #C86B00 100%);">
                    Edit
                </button>
                <button id="btn-delete" class="hidden items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans" 
                    style="background: linear-gradient(66.3deg, #623400 0%, #C86B00 100%);">
                    - Delete
                </button>
                    <button @click="openModal = true" 
                    class="flex items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans hover:scale-105 active:scale-95" 
                    style="background: linear-gradient(266.65deg, #DBD400 0%, #F59E0B 100%);">
                <span class="mr-2 text-lg">+</span> Tambah Produk
            </button>
            </div>
        </div>

       <div class="mb-6" x-data="{ open: false, selected: 'Semua Kategori' }">
    <div class="relative inline-block w-64">
        <button 
            @click="open = !open" 
            @click.away="open = false"
            type="button"
            style="color: #151515; font-size: 18px; background-color: #ECEDED;" 
            class="flex items-center justify-between w-full border border-[#0000004D] px-4 py-2 rounded-md font-semibold outline-none cursor-pointer">
            
            <span x-text="selected"></span>
            
            <div class="flex items-center text-gray-700">
                <svg class="h-5 w-5 transition-transform" :class="open ? 'rotate-180' : ''" viewbox="0 0 20 20" fill="currentColor">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </div>
        </button>

        <div 
            x-show="open" 
            x-transition
            style="background-color: #ECEDED; border: 1px solid #0000004D;"
            class="absolute z-50 w-full mt-1 rounded-md shadow-lg overflow-hidden">
            <ul class="py-1 text-[#151515]">
                @foreach(['Semua Kategori', 'Bahan Kering', 'Bumbu', 'Nabati', 'Hewani', 'Bahan Masak', 'Frozen Food', 'Instan', 'Minuman'] as $kat)
                <li>
                    <button 
                        @click="selected = '{{ $kat }}'; open = false"
                        type="button"
                        class="w-full text-left px-4 py-2 hover:bg-[#D1D2D2] transition-colors">
                        {{ $kat }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

        <div class="bg-white rounded-xl border border-stocking-border overflow-hidden shadow-sm">
            <div class="overflow-x-auto table-container">
                <table class="w-full text-left border-separate border-spacing-0"> <thead>
                    <tr style="color: #595959; font-size: 18px; background-color: #FDFCF8;" class="font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-28 border-t-2 border-b-2 border-l-2 border-[#F6A821] rounded-l-lg bg-[#FDFCF8]">
                            <div class="flex items-center">
                                <input type="checkbox" id="check-all" class="custom-checkbox mr-3"/>
                                <span>Semua</span>
                            </div>
                        </th>
            <th class="py-4 px-6 border-y-2 border-[#F6A821]">NAMA ITEM</th>
            <th class="py-4 px-6 border-y-2 border-[#F6A821]">KATEGORI</th>
            <th class="py-4 px-6 border-y-2 border-[#F6A821]">STOK</th>
            <th class="py-4 px-6 border-y-2 border-[#F6A821]">STOK MIN</th>
            <th class="py-4 px-6 border-t-2 border-b-2 border-r-2 border-[#F6A821] rounded-r-lg bg-[#FDFCF8]">HARGA</th>
        </tr>
            </thead>
            <tbody style="color: #1D1D1D; font-size: 16px;" class="font-medium">
                @forelse($bahan as $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6">
                        <input type="checkbox" class="custom-checkbox item-checkbox"/>
                    </td>
                    <td class="py-4 px-6">{{ $item->nama_item }}</td>
                    <td class="py-4 px-6">{{ $item->kategori }}</td>
                    <td class="py-4 px-6">{{ $item->stok }} {{ $item->satuan }}</td>
                    <td class="py-4 px-6">{{ $item->stok_min }} {{ $item->satuan }}</td>
                    <td class="py-4 px-6">Rp. {{ number_format($item->harga, 0, ',', '.') }}/{{ $item->satuan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">
                        Data belum ada di gudang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
            </div>
        </div>
    </main>
</div>

    <div x-show="openModal" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" 
     x-transition
     x-cloak>
    
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 relative mx-4" @click.away="openModal = false">
    <button @click="openModal = false" class="absolute top-4 right-6 text-gray-400 hover:text-black text-3xl">&times;</button>

    <h2 class="text-2xl font-bold text-black mb-6">Tambah produk</h2>

    <form action="#" method="POST" class="space-y-4">
        @csrf
        
        <div data-purpose="form-group">
            <label class="block text-base font-semibold text-black mb-1.5" for="nama_produk">Nama produk</label>
            <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" 
                   id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk" type="text"/>
        </div>

       <div data-purpose="form-group">
    <label class="block text-base font-semibold text-black mb-1.5" for="kategori">Kategori</label>
    <div class="relative">
        <select 
            @change="if($el.value === 'tambah_kategori') { openCategoryModal = true; $el.value = ''; }"
            class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none appearance-none focus:ring-2 focus:ring-yellow-400 cursor-pointer" 
            id="kategori" name="kategori">
            <option value="" disabled selected style="display: none;">Pilih kategori produk</option>
            <option value="bahan_kering">Bahan kering</option>
            <option value="bumbu">Bumbu</option>
            <option value="nabati">Nabati</option>
            <option value="hewani">Hewani</option>
            <option value="bahan_masak">Bahan masak</option>
            <option value="frozen_food">Frozen food</option>
            <option value="instan">Instan</option>
            <option value="minuman">Minuman</option>
            <option value="tambah_kategori" class="text-blue-600 font-bold">+ Tambah kategori</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </div>
    </div>
</div>

        <div data-purpose="form-group">
            <label class="block text-base font-semibold text-black mb-1.5">Stok</label>
            <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" 
                   name="stok" placeholder="Masukkan jumlah produk" type="number"/>
        </div>

        <div data-purpose="form-group">
            <label class="block text-base font-semibold text-black mb-1.5">Min Stok</label>
            <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" 
                   name="min_stok" placeholder="Masukkan jumlah minimal produk" type="number"/>
        </div>

        <div data-purpose="form-group">
            <label class="block text-base font-semibold text-black mb-1.5">Harga</label>
            <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" 
                   name="harga" placeholder="Masukkan harga produk" type="number"/>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-[#151515] text-white px-12 py-3 rounded-xl font-bold hover:bg-black transition-all w-full md:w-auto">
                Konfirmasi
            </button>
        </div>
    </form>
</div>

    <div x-show="openCategoryModal" 
     class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-40" 
     x-transition x-cloak>
    
    <div class="bg-[#EDEDED] w-full max-w-lg rounded-xl shadow-2xl p-6 relative mx-4" 
         @click.stop
         @click.away="openCategoryModal = false">
        
        <button @click="openCategoryModal = false" class="absolute top-4 right-4 text-black text-2xl font-bold">&times;</button>

        <h2 class="text-xl font-bold text-black mb-4">Tambah kategori</h2>
        <form action="#" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2">Nama Kategori</label>
                <input type="text" placeholder="Masukkan nama kategori" 
                       class="w-full p-3 bg-white border border-gray-300 rounded-lg outline-none">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[#151515] text-white px-6 py-2 rounded-lg font-bold hover:bg-black transition-all">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- LOGIKA MODAL LOGOUT (PINDAH KE BODY) ---
        const modalLogout = document.getElementById('logoutModal');
        if (modalLogout) {
            document.body.appendChild(modalLogout);
        }

        // --- LOGIKA CHECKBOX INVENTARIS ---
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const btnEdit = document.getElementById('btn-edit');
        const btnDelete = document.getElementById('btn-delete');
        const checkAll = document.getElementById('check-all');

        function updateButtons() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;

            if (checkedCount === 1) {
                btnEdit.classList.remove('hidden');
                btnEdit.classList.add('flex');
                btnDelete.classList.remove('hidden');
                btnDelete.classList.add('flex');
            } else if (checkedCount > 1) {
                btnEdit.classList.add('hidden');
                btnEdit.classList.remove('flex');
                btnDelete.classList.remove('hidden');
                btnDelete.classList.add('flex');
            } else {
                btnEdit.classList.add('hidden');
                btnDelete.classList.add('hidden');
            }
        }

        // Jalankan event listener untuk setiap checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateButtons);
        });

        // Jalankan event listener untuk Check All
        if (checkAll) {
            checkAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
                updateButtons();
            });
        }
    });

    // --- FUNGSI MODAL (Ditaruh di luar agar bisa dipanggil onclick) ---
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) modal.style.display = 'none';
    }

    // Tutup modal jika klik di luar area konten modal
    window.addEventListener('click', function(event) {
        const modalLogout = document.getElementById('logoutModal');
        if (event.target == modalLogout) {
            closeLogoutModal();
        }
        
        // Jika kamu punya modal "Tambah Produk", tambahkan juga di sini:
        const modalTambah = document.getElementById('modal');
        if (event.target == modalTambah) {
            // closeModal(); // Sesuai fungsi tutup modal tambahmu
        }
    });
</script>

<div id="logoutModal" style="display: none; position: fixed; inset: 0; z-index: 9999; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="bg-[#EDEDED] rounded-[20px] p-10 shadow-2xl max-w-sm w-full mx-4 text-center font-sans">
        <h3 class="text-[22px] font-bold text-[#151515] mb-8 leading-tight">Apakah Anda Yakin Ingin Keluar?</h3>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28">Batal</button>
            <a href="{{ url('/') }}" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28 flex items-center justify-center">Konfirmasi</a>
        </div>
    </div>
</div>
</body>
</html>