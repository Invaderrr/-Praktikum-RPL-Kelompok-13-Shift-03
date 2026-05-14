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
        [x-cloak] { display: none !important; }
        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }
        select::-ms-expand { display: none !important; }
        .table-container::-webkit-scrollbar { width: 6px; }
        .table-container::-webkit-scrollbar-thumb { background-color: #d1d5db; border-radius: 3px; }
        .custom-checkbox {
            appearance: none;
            background-color: #151515;
            border: 2px solid rgba(0, 0, 0, 0.30);
            border-radius: 4px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .custom-checkbox:checked {
            background-color: #F2C94C !important; 
            border: 2px solid #000000 !important;
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
<body class="flex h-screen overflow-hidden bg-white" x-data="{ openModal: false, openEditModal: false, editId: null, editData: {}, openCategoryModal: false }">

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
            <img alt="Home Icon" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'brightness-0' : 'opacity-60 grayscale' }}" src="{{ asset('img/Home.png') }}"/>
            <span class="text-sm">Dashboard</span>
        </a>

        <a href="{{ route('admin.inventaris') }}" 
            class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200 
            {{ request()->routeIs('admin.inventaris') ? 'text-black shadow-sm' : 'text-gray-500 hover:text-black' }}"
            style="{{ request()->routeIs('admin.inventaris') ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' : 'background: transparent;' }}">
            <img alt="Inventaris Icon" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.inventaris') ? 'brightness-0' : 'opacity-60 grayscale' }}" src="{{ asset('img/Inventoris.png') }}"/> 
            <span class="text-sm">Inventaris</span>
        </a>
    </nav>
    <div class="p-4 space-y-2">
        <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="{{ route('admin.pengaturan') }}">
            <img alt="Settings Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Settings.png') }}"/>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>
        <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="#">
            <img alt="Logout Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Logout.png') }}"/>
            <span class="text-sm font-medium">Log Out</span>
        </a>
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
                <button id="btn-edit" class="hidden items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans" style="background: linear-gradient(66.3deg, #623400 0%, #C86B00 100%);">Edit</button>
                <button id="btn-delete" class="hidden items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans" style="background: linear-gradient(66.3deg, #623400 0%, #C86B00 100%);">- Delete</button>
                <button @click="openModal = true" class="flex items-center text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition-all font-sans hover:scale-105 active:scale-95" style="background: linear-gradient(266.65deg, #DBD400 0%, #F59E0B 100%);">
                    <span class="mr-2 text-lg">+</span> Tambah Produk
                </button>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="mb-6" x-data="{ open: false, selected: 'Semua Kategori' }">
            <div class="relative inline-block w-64">
                <button @click="open = !open" @click.away="open = false" type="button" style="color: #151515; font-size: 18px; background-color: #ECEDED;" class="flex items-center justify-between w-full border border-[#0000004D] px-4 py-2 rounded-md font-semibold outline-none cursor-pointer">
                    <span x-text="selected"></span>
                    <div class="flex items-center text-gray-700">
                        <svg class="h-5 w-5 transition-transform" :class="open ? 'rotate-180' : ''" viewbox="0 0 20 20" fill="currentColor">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                        </svg>
                    </div>
                </button>
                <div x-show="open" x-transition style="background-color: #ECEDED; border: 1px solid #0000004D;" class="absolute z-50 w-full mt-1 rounded-md shadow-lg overflow-hidden">
                    <ul class="py-1 text-[#151515]">
                        @foreach(['Semua Kategori', 'Bahan Kering', 'Bumbu', 'Nabati', 'Hewani', 'Bahan Masak', 'Frozen Food', 'Instan', 'Minuman'] as $kat)
                        <li>
                            <button @click="selected = '{{ $kat }}'; open = false" type="button" class="w-full text-left px-4 py-2 hover:bg-[#D1D2D2] transition-colors">{{ $kat }}</button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-stocking-border overflow-hidden shadow-sm">
            <div class="overflow-x-auto table-container">
                <table class="w-full text-left border-separate border-spacing-0"> 
                    <thead>
                        <tr style="color: #595959; font-size: 18px; background-color: #FDFCF8;" class="font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-28 border-t-2 border-b-2 border-l-2 border-[#F6A821] rounded-l-lg bg-[#FDFCF8]">
                                <div class="flex items-center">
                                    <input type="checkbox" id="check-all" class="custom-checkbox mr-3"/>
                                    <span>Semua</span>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-y-2 border-[#F6A821]">NAMA BAHAN</th>
                            <th class="py-4 px-6 border-y-2 border-[#F6A821]">STOK</th>
                            <th class="py-4 px-6 border-y-2 border-[#F6A821]">KATEGORI</th>
                            <th class="py-4 px-6 border-y-2 border-[#F6A821]">SATUAN</th>
                            <th class="py-4 px-6 border-t-2 border-b-2 border-r-2 border-[#F6A821] rounded-r-lg bg-[#FDFCF8]">HARGA</th>
                        </tr>
                    </thead>
                    <tbody style="color: #1D1D1D; font-size: 16px;" class="font-medium">
                        {{-- DISESUAIKAN DENGAN image_476d38.png --}}
                        @forelse($inventaris as $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors" data-kategori="{{ $item->kategori }}">
                            <td class="py-4 px-6">
                                <input type="checkbox" class="custom-checkbox item-checkbox" value="{{ $item->id_bahan_baku }}"/>
                            </td>
                            <td class="py-4 px-6">{{ $item->nama_bahan }}</td>
                            <td class="py-4 px-6">{{ $item->stok }}</td>
                            <td class="py-4 px-6">
                                {{ $item->kategori }}
                            </td>
                            <td class="py-4 px-6">{{ $item->satuan }}</td>
                            <td class="py-4 px-6">Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">Data bahan baku belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Edit Produk -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40" style="display: none;">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 relative mx-4">
        <button type="button" class="absolute top-4 right-6 text-gray-400 hover:text-black text-3xl">&times;</button>
        <h2 class="text-2xl font-bold text-black mb-6">Edit Produk</h2>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="edit_nama_bahan">Nama bahan</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" id="edit_nama_bahan" name="nama_bahan" placeholder="Masukkan nama bahan baku" type="text" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="edit_stok">Stok</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" id="edit_stok" name="stok" placeholder="Masukkan jumlah stok" type="number" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="edit_satuan">Satuan</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" id="edit_satuan" name="satuan" placeholder="Contoh: kg, liter, pcs" type="text" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="edit_harga">Harga</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" id="edit_harga" name="harga" placeholder="Masukkan harga bahan" type="number" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="edit_kategori">Kategori</label>
                <select id="edit_kategori" name="kategori" class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" required>
                    @foreach(['Bahan Kering', 'Bumbu', 'Nabati', 'Hewani', 'Bahan Masak', 'Frozen Food', 'Instan', 'Minuman'] as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" class="px-6 py-3 rounded-xl font-bold border border-gray-300 hover:bg-gray-50 transition-all" onclick="document.getElementById('editModal').style.display='none';">Batal</button>
                <button type="submit" class="bg-[#151515] text-white px-12 py-3 rounded-xl font-bold hover:bg-black transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" x-transition x-cloak>
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 relative mx-4" @click.away="openModal = false">
        <button @click="openModal = false" class="absolute top-4 right-6 text-gray-400 hover:text-black text-3xl">&times;</button>
        <h2 class="text-2xl font-bold text-black mb-6">Tambah produk</h2>

        <form action="{{ route('admin.inventaris.store') }}" method="POST" class="space-y-4">
            @csrf
            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="nama_bahan">Nama bahan</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" id="nama_bahan" name="nama_bahan" placeholder="Masukkan nama bahan baku" type="text" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="stok">Stok</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" name="stok" placeholder="Masukkan jumlah stok" type="number" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="satuan">Satuan</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" name="satuan" placeholder="Contoh: kg, liter, pcs" type="text" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="harga">Harga</label>
                <input class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" name="harga" placeholder="Masukkan harga bahan" type="number" required/>
            </div>

            <div data-purpose="form-group">
                <label class="block text-base font-semibold text-black mb-1.5" for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="w-full p-3 bg-[#F9F9F9] border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-yellow-400" required>
                    <option value="">Pilih kategori</option>
                    @foreach(['Bahan Kering', 'Bumbu', 'Nabati', 'Hewani', 'Bahan Masak', 'Frozen Food', 'Instan', 'Minuman'] as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" @click="openModal = false" class="px-6 py-3 rounded-xl font-bold border border-gray-300 hover:bg-gray-50 transition-all">Batal</button>
                <button type="submit" class="bg-[#151515] text-white px-12 py-3 rounded-xl font-bold hover:bg-black transition-all">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<script>
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const btnEdit = document.getElementById('btn-edit');
    const btnDelete = document.getElementById('btn-delete');
    const checkAll = document.getElementById('check-all');

    function updateButtons() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (checkedCount === 1) {
            btnEdit.classList.remove('hidden'); btnEdit.classList.add('flex');
            btnDelete.classList.remove('hidden'); btnDelete.classList.add('flex');
        } else if (checkedCount > 1) {
            btnEdit.classList.add('hidden'); btnEdit.classList.remove('flex');
            btnDelete.classList.remove('hidden'); btnDelete.classList.add('flex');
        } else {
            btnEdit.classList.add('hidden'); btnDelete.classList.add('hidden');
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateButtons));
    checkAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = checkAll.checked);
        updateButtons();
    });

    // Edit button handler
    btnEdit.addEventListener('click', () => {
        const checkedCheckbox = document.querySelector('.item-checkbox:checked');
        if (checkedCheckbox) {
            const row = checkedCheckbox.closest('tr');
            const cells = row.querySelectorAll('td');
            const hargaText = cells[4].textContent.trim().replace('Rp. ', '').replace(/\./g, '');
            
            // Update form values
            document.getElementById('edit_nama_bahan').value = cells[1].textContent.trim();
            document.getElementById('edit_stok').value = cells[2].textContent.trim();
            document.getElementById('edit_satuan').value = cells[3].textContent.trim();
            document.getElementById('edit_harga').value = hargaText;

            // Kategori (ambil dari dataset)
            const kategoriText = row.getAttribute('data-kategori') || row.dataset.kategori || '';
            document.getElementById('edit_kategori').value = kategoriText;
            
            // Update form action
            const editForm = document.getElementById('editForm');
            editForm.action = `/admin/inventaris/${checkedCheckbox.value}`;
            
            // Show modal (hapus class hidden biar bisa dipencet)
            const editModal = document.getElementById('editModal');
            editModal.classList.remove('hidden');
            editModal.style.display = 'flex';
        }
    });

    // Close edit modal button
    const editCloseBtn = document.querySelector('#editModal button[type="button"]');
    if (editCloseBtn) {
        editCloseBtn.addEventListener('click', () => {
            const editModal = document.getElementById('editModal');
            editModal.style.display = 'none';
            editModal.classList.add('hidden');
        });
    }

    // Close edit modal when clicking outside
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.style.display = 'none';
            editModal.classList.add('hidden');
        }
    });

    // Delete button handler
    btnDelete.addEventListener('click', () => {
        const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkedCheckboxes.length > 0) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCheckboxes.length} item?`)) {
                checkedCheckboxes.forEach((cb, index) => {
                    setTimeout(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/inventaris/${cb.value}`;
                        form.style.display = 'none';
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }, index * 500);
                });
            }
        }
    });
</script>

</body>
</html>