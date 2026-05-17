<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>StocKING - Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { 
            background-color: #FDFCF8; 
            font-family: 'Montserrat', sans-serif; 
        }

        /* CSS Summary Card Bertumpuk (Identik Dashboard Admin) */
        .summary-card-container { 
            width: 244px; 
            height: 135px; 
            position: relative; 
        }
        .card-bottom-layer { 
            position: absolute;
            width: 244px; height: 101px; top: 34px; left: 0; 
            background-color: #FEF3C7; border-radius: 10px; z-index: 1;
        }
        .card-top-layer { 
            position: absolute;
            width: 244px; height: 120px; top: 0; left: 0; 
            background: linear-gradient(135deg, #F59E0B 0%, #DBD400 100%); 
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2); 
            z-index: 2; padding: 20px; display: flex; flex-direction: column; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .card-top-layer h6 { font-size: 18px; font-weight: 700; color: #FFFFFF; margin: 0; }
        .card-top-layer h3 { font-size: 24px; font-weight: 700; color: #FFFFFF; margin: 5px 0 0 0; }
        .card-top-layer img { position: absolute; bottom: 15px; right: 15px; width: 32px; height: 32px; }

        /* Style Section Tabel */
        .transaction-section { 
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px; 
            margin-top: 40px; padding: 0; background-color: #FFFFFF; 
            overflow: hidden;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden" style="background-color: #FDFCF8;">

    <aside class="w-64 border-r border-gray-200 flex flex-col h-full" style="background-color: #FDFCF8;">
        <div class="p-6">
            <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/> 
        </div>

        <nav class="flex-1 px-4 mt-4 space-y-2">
            <a href="{{ route('user.belanja') }}" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">
                <img alt="Belanja Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Belanja_Off.png') }}"/> 
                <span class="text-sm font-medium">Belanja</span>
            </a>

            <a href="{{ route('user.transaksi') }}" 
               class="flex items-center px-4 py-2 rounded-lg font-semibold text-black shadow-sm"
               style="background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);"> 
                <img alt="Transaksi Icon" class="w-5 h-5 mr-3 brightness-0" src="{{ asset('img/Transaksi_Off.png') }}"/>
                <span class="text-sm">Transaksi</span>
            </a>
        </nav>

        <div class="p-4 space-y-2">
            <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="{{ route('user.pengaturan') }}">
                <img alt="Settings Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Pengaturan_On.png') }}"/>
                <span class="text-sm font-medium">Pengaturan</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors font-semibold">
                    <img alt="Logout Icon" class="w-5 h-5 mr-3 opacity-60 grayscale" src="{{ asset('img/Log out_Off.png') }}"/>
                    <span class="text-sm">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 border-b border-gray-200 flex items-center justify-end px-8" style="background-color: #FDFCF8;">
            @php
                // Ambil foto dari session atau database auth milik user
                $fotoUser = session('foto') ?? (Auth::check() ? Auth::user()->foto : 'default.png');
                $username = auth()->user()->username ?? 'User';
                $initial = strtoupper(substr($username, 0, 1));
            @endphp

            <div class="flex items-center justify-center text-white border border-white shadow-sm overflow-hidden" 
                 style="width: 40px; height: 40px; background-color: #F2C94C; border-radius: 50%; font-weight: 700; font-size: 18px; background-image: url('{{ ($fotoUser && $fotoUser !== 'default.png') ? asset('avatars/' . $fotoUser) : '' }}'); background-size: cover; background-position: center;">
                
                @if(!$fotoUser || $fotoUser === 'default.png')
                    <span>{{ $initial }}</span>
                @endif
            </div>
        </header>

        <main class="flex-1 overflow-y-auto px-10 pb-10 pt-8" style="background-color: #FDFCF8;">
            <div class="mb-8">
                <h2 class="text-[33px] font-bold text-[#151515]">Riwayat Transaksi</h2>
                <p class="text-[#595959] text-sm font-medium">Lihat Semua Transaksi Anda</p>
            </div>

            <div class="flex gap-x-6">
                <div class="summary-card-container">
                    <div class="card-bottom-layer"></div>
                    <div class="card-top-layer">
                        <h6>Total Transaksi</h6>
                        <h3>{{ $riwayat->count() }} Pembelian</h3>
                        <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                    </div>
                </div>

                <div class="summary-card-container">
                    <div class="card-bottom-layer"></div>
                    <div class="card-top-layer">
                        <h6>Total Biaya</h6>
                        <h3>Rp {{ number_format($riwayat->sum('total_harga'), 0, ',', '.') }}</h3>
                        <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                    </div>
                </div>
            </div>

            <div class="transaction-section">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FEF3C7] text-black text-sm font-bold border-b border-gray-200"> 
                            <th class="px-6 py-4">Tanggal/Waktu</th>
                            <th class="px-6 py-4">Nama Item</th>
                            <th class="px-6 py-4">Harga Satuan</th>
                            <th class="px-6 py-4">Jumlah</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Jenis</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse($riwayat as $t)
                            @foreach($t->details as $index => $detail)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">
                                    @if($index === 0)
                                        <div class="font-bold">{{ $t->tanggal_transaksi->format('d M Y') }}</div>
                                        @php
                                            $jam = $t->jam_transaksi;
                                            $jamTxt = $jam ? \Carbon\Carbon::parse($jam)->format('H:i') : ($t->tanggal_transaksi ? $t->tanggal_transaksi->format('H.i') : '-');
                                        @endphp
                                        <div class="text-[10px] text-gray-400">{{ $jamTxt }} WIB</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">{{ $detail->nama_item ?? $detail->bahanBaku->nama_bahan ?? '-' }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">{{ $detail->jumlah }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    @if($index === 0)
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
                        @empty
                            <tr>
                                <td colspan="7" class="py-20 text-center text-gray-400 font-bold italic">Belum ada riwayat transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>