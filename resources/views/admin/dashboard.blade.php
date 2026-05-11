<!DOCTYPE html>
<html lang="en">
<head>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>StocKING - Dashboard</title>
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
        
        /* CSS Summary Card Bertumpuk Kamu */
        .summary-card-container { width: 244px; height: 135px; position: relative; }
        .card-bottom-layer { 
            position: absolute; width: 244px; height: 101px; top: 34px; left: 0; 
            background-color: #FEF3C7; border-radius: 10px; z-index: 1; 
        }
        .card-top-layer { 
            position: absolute; width: 244px; height: 120px; top: 0; left: 0; 
            background: linear-gradient(135deg, #F59E0B 0%, #DBD400 100%); 
            border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); 
            z-index: 2; padding: 20px; display: flex; flex-direction: column; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        .card-top-layer h6 { font-size: 18px; font-weight: 700; color: #FFFFFF; margin: 0; }
        .card-top-layer h3 { font-size: 24px; font-weight: 700; color: #FFFFFF; margin: 5px 0 0 0; }
        .card-top-layer img { position: absolute; bottom: 15px; right: 15px; width: 32px; height: 32px; }

        /* Style Section Transaksi */
        .transaction-section { 
            border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 10px; 
            margin-top: 40px; padding: 30px; background-color: #FFFFFF; 
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <aside class="w-64 border-r border-stocking-border flex flex-col bg-[#FFFFFF] h-full">
    <div class="p-6">
        <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/>
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

        <a href="{{ route('admin.inventaris') }}" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">
            <img alt="Inventaris Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Inventoris.png') }}"/>
            <span class="text-sm font-medium">Inventaris</span>
        </a>
    </nav>

    <div class="p-4 space-y-2">
        <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="{{ route('admin.pengaturan') }}">
            <img alt="Settings Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Settings.png') }}"/>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>

    <button onclick="openLogoutModal()" 
            class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors font-semibold focus:outline-none">
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
            <img alt="Notification Icon" class="w-6 h-6" src="{{ asset('img/Notifikasi.png') }}"/>
            <div class="w-10 h-10 rounded-full bg-[#00DBFF] flex items-center justify-center text-white font-bold border border-white shadow-sm">
                {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-10 pb-10 pt-2 bg-white">
        <div class="mb-6">
            <h2 style="color: #151515; font-size: 33.05px;" class="font-bold">Dashboard</h2>
            <p style="color: #595959;" class="text-sm">Hallo, {{ ucfirst(auth()->user()->username ?? 'Admin StocKING') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-6">
            <div class="summary-card-container">
                <div class="card-bottom-layer"></div>
                <div class="card-top-layer">
                    <h6>Total Transaksi</h6>
                    <h3>{{ $totalTransaksi }} Penjualan</h3>
                    <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                </div>
            </div>
            <div class="summary-card-container">
                <div class="card-bottom-layer"></div>
                <div class="card-top-layer">
                    <h6>Pemasukan</h6>
                    <h3>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                    <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                </div>
            </div>
            <div class="summary-card-container">
                <div class="card-bottom-layer"></div>
                <div class="card-top-layer">
                    <h6>Total Bahan Baku</h6>
                    <h3>{{ $totalBahan }}</h3>
                    <img src="{{ asset('img/Package.png') }}" alt="Package">
                </div>
            </div>
            <div class="summary-card-container">
                <div class="card-bottom-layer"></div>
                <div class="card-top-layer">
                    <h6>Peringatan Stok</h6>
                    <h3>{{ $stokMenipis }} Bahan</h3>
                    <img src="{{ asset('img/Warning.png') }}" alt="Warning">
                </div>
            </div>
        </div> 
        <div class="transaction-section mt-12">
    <h3 class="text-2xl font-bold mb-6">Transaksi Terbaru</h3>

    @if($transaksiTerbaru->count() > 0)
        <div class="overflow-hidden rounded-xl border border-[#FEF3C7]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#FEF3C7] text-black text-sm font-bold">
                        <th class="px-4 py-3">Tanggal/Waktu</th>
                        <th class="px-4 py-3">Nama Item</th>
                        <th class="px-4 py-3">Harga Satuan</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($transaksiTerbaru as $t)
                        @foreach($t->details as $index => $d)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">
                                @if($index == 0)
                                    {{ $t->created_at->format('d M Y') }}<br>
                                    <span class="text-[10px]">{{ $t->created_at->format('H.i') }} WIB</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $d->nama_item }}</td>
                            <td class="px-4 py-2 text-sm">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $d->jumlah }}</td>
                            <td class="px-4 py-2 text-sm">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($index == 0)
                                    Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                @if($index == 0)
                                    {{ ucfirst($t->metode_pembayaran) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-10 opacity-50">
            <img src="{{ asset('img/Frown.png') }}" alt="Empty" class="w-16 h-16 mb-4">
            <p class="text-lg font-semibold">Maaf, tidak ada transaksi terbaru</p>
        </div>
    @endif
</div>

<script>
    // Pastikan modal berada di layer terluar saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        const modalLogout = document.getElementById('logoutModal');
        if (modalLogout) {
            document.body.appendChild(modalLogout);
        }
    });

    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) modal.style.display = 'none';
    }

    // Klik di luar modal untuk menutup
    window.addEventListener('click', function(event) {
        const modalLogout = document.getElementById('logoutModal');
        if (event.target == modalLogout) {
            closeLogoutModal();
        }
    });
</script>

<div id="logoutModal" style="display: none; position: fixed; inset: 0; z-index: 9999; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="bg-[#EDEDED] rounded-[20px] p-10 shadow-2xl max-w-sm w-full mx-4 text-center font-sans">
        <h3 class="text-[22px] font-bold text-[#151515] mb-8 leading-tight">Apakah anda yakin ingin keluar?</h3>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28">Batal</button>
            <a href="{{ url('/') }}" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28 flex items-center justify-center">Konfirmasi</a>
        </div>
    </div>
</div>
<body>
</html>