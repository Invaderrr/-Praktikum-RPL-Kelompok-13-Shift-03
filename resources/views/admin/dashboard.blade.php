<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - StocKING</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #FDFCF8;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 289px;
            height: 100vh;
            background-color: #FDFCF8;
            border-right: 1px solid rgba(0, 0, 0, 0.3); 
            display: flex;
            flex-direction: column;
            padding: 20px;
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px 10px;
        }

        .brand-logo img {
            width: 180px;
            height: auto;
            object-fit: contain;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            margin: 0 20px 10px 20px;
            border-radius: 10.64px;
            color: #595959;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: 0.3s;
        }

        .menu-item img {
            width: 18.75px;
            margin-right: 15px;
            opacity: 0.8; 
            transition: 0.3s;
        }

        /* Kondisi Menu Active */
        .menu-item.active {
            background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);
            color: #151515; 
        }

        .menu-item.active img {
            filter: brightness(0); 
            opacity: 1;
        }

        .sidebar-bottom {
            margin-top: auto;
            margin-bottom: 20px;
        }

        .sidebar-bottom .menu-item {
            margin-bottom: 2px;
        }

        /* Main Content & Layout Fix */
        .main-content {
            margin-left: 289px; 
            padding-top: 98.38px; /* Biar konten gak ketutup header fixed */
            background-color: #FDFCF8; 
            min-height: 100vh;
        }

        /* Header Styling */
        .top-header {
            width: calc(100% - 289px); 
            height: 98.38px;
            background-color: #FDFCF8;
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 289px; 
            z-index: 999;
            justify-content: flex-end; /* Memaksa konten ikon & profil ke kanan */
            padding: 0 40px;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .notif-icon {
            width: 25.53px;
            height: 28.36px;
        }

        /* Dashboard Body */
        .dashboard-body {
            padding: 40px;
        }

        .dashboard-title {
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 5px;
            color: #000000;
        }

        .dashboard-subtitle {
            font-weight: 400;
            font-size: 18px;
            color: #595959;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .report-date {
            font-size: 18px;
            font-weight: 700;
            color: #D97706;
            text-align: center;
            margin-bottom: 35px;
        }

        /* Summary Cards Layout Fix */
        .summary-card-container {
            width: 100%;
            max-width: 244px;
            height: 135px;
            position: relative;
            margin: 0 auto;
        }

        .card-bottom-layer {
            position: absolute;
            width: 100%;
            height: 101px;
            top: 34px;
            left: 0;
            background-color: #FEF3C7;
            border-radius: 10px;
            z-index: 1;
        }

        .card-top-layer {
            position: absolute;
            width: 100%;
            height: 120px;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #F59E0B 0%, #DBD400 100%);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 2;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-top-layer h6 {
            font-size: 18px;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0;
        }

        .card-top-layer h3 {
            font-size: 24px;
            font-weight: 700;
            color: #FFFFFF;
            margin: 5px 0 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-top-layer img {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 32px;
            height: 32px;
        }

        /* Transaksi Terbaru Section */
        .transaction-section {
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            height: 400px;
            margin-top: 50px;
            padding: 30px;
            background-color: #FFFFFF;
        }

        .transaction-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
        }

        .empty-state img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .empty-state p {
            font-weight: 600;
            font-size: 20px;
            color: rgba(29, 29, 29, 0.5);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand-logo">
            <img src="{{ asset('img/STOCKING.png') }}" alt="Logo StocKING">
        </div>
    
        <a href="{{ route('admin.dashboard') }}" class="menu-item active">
            <img src="{{ asset('img/Dashboard_On.png') }}" alt="Home"> Dashboard
        </a>

        <a href="{{ route('admin.inventaris') }}" class="menu-item">
            <img src="{{ asset('img/Inventaris_On.png') }}" alt="Inventaris"> Inventaris
        </a>

        <div class="sidebar-bottom">
            <a href="{{ route('admin.pengaturan') }}" class="menu-item" style="color: #595959; background: transparent;">
                <img src="{{ asset('img/Pengaturan_On.png') }}" alt="Pengaturan"> Pengaturan
            </a>
            <a href="#" class="menu-item" style="color: rgba(89,89,89,0.5); background: transparent;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('img/Log out_On.png') }}" alt="Logout"> Log Out
            </a>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        
        <header class="top-header">
            <div class="header-icons">
                
                
                @php
                    // Ambil foto dari session atau database auth
                    $fotoAdmin = session('foto') ?? (Auth::check() ? Auth::user()->foto : 'default.png');
                    $username = auth()->user()->username ?? 'Admin';
                    $initial = strtoupper(substr($username, 0, 1));
                @endphp

                <div class="w-10 h-10 rounded-full d-flex align-items-center justify-content-center text-white font-bold border border-white shadow-sm overflow-hidden" 
                     style="width: 47.5px; height: 47.5px; background-color: #00EAFF; border-radius: 50%; font-weight: 700; font-size: 20px; background-image: url('{{ ($fotoAdmin && $fotoAdmin !== 'default.png') ? asset('avatars/' . $fotoAdmin) : '' }}'); background-size: cover; background-position: center;">
                    
                    @if(!$fotoAdmin || $fotoAdmin === 'default.png')
                        <span>{{ $initial }}</span>
                    @endif
                </div>
            </div>
        </header>

        <div class="dashboard-body">
            <div class="dashboard-title">Dashboard</div>
            <div class="dashboard-subtitle">Hallo, {{ ucfirst(auth()->user()->username ?? 'Admin StocKING') }}</div>

            @php
                \Carbon\Carbon::setLocale('id');
                $tanggalMulai = \Carbon\Carbon::now()->subDays(6)->translatedFormat('d F Y');
                $tanggalAkhir = \Carbon\Carbon::now()->translatedFormat('d F Y');
            @endphp
            <div class="report-date">
                Laporan Periode {{ $tanggalMulai }} s/d {{ $tanggalAkhir }}
            </div>

            <div class="row g-4">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="summary-card-container">
                        <div class="card-bottom-layer"></div>
                        <div class="card-top-layer">
                            <h6>Total Transaksi</h6>
                            <h3>{{ $totalTransaksi }} Penjualan</h3>
                            <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="summary-card-container">
                        <div class="card-bottom-layer"></div>
                        <div class="card-top-layer">
                            <h6>Pemasukan</h6>
                            <h3>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                            <img src="{{ asset('img/Grafik.png') }}" alt="Grafik">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="summary-card-container">
                        <div class="card-bottom-layer"></div>
                        <div class="card-top-layer">
                            <h6>Total Bahan Baku</h6>
                            <h3>{{ $totalBahan }}</h3>
                            <img src="{{ asset('img/Total Bahan Baku.png') }}" alt="Package">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="summary-card-container">
                        <div class="card-bottom-layer"></div>
                        <div class="card-top-layer">
                            <h6>Peringatan Stok</h6>
                            <h3>{{ $stokMenipis }}</h3>
                            <img src="{{ asset('img/Peringatan.png') }}" alt="Warning">
                        </div>
                    </div>
                </div>
            </div>

            <div class="transaction-section">
                <div class="transaction-title">Transaksi Terbaru</div>
                
                @if(count($transaksiTerbaru) > 0)
                    <div style="max-height: 270px; overflow-y: auto; overflow-x: hidden; border-radius: 10px;">
                        <table class="table table-borderless" style="margin-bottom:0;">
                            <thead style="border: 1px solid #D97706; border-radius: 10px; background: #FFFFFF; position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th>Tanggal/Waktu</th>
                                    <th>Nama Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $d)
                                    <tr>
                                        <td>
                                            @php
                                                $tgl = optional($d->transaksi)->tanggal_transaksi;
                                                $tglFmt = $tgl ? \Carbon\Carbon::parse($tgl)->translatedFormat('d M Y') : '-';
                                                $jamRaw = optional($d->transaksi)->jam_transaksi;
                                                $jamFmt = $jamRaw ? \Carbon\Carbon::parse($jamRaw)->format('H:i') : '';
                                            @endphp
                                            {{ $tglFmt }}
                                            <div style="font-size: 12px; color: rgba(0,0,0,0.35)">
                                                {{ $jamFmt }}
                                            </div>
                                        </td>
                                        <td>{{ $d->bahanBaku->nama_bahan ?? '-' }}</td>
                                        <td>Rp {{ number_format($d->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $d->jumlah ?? 0 }}</td>
                                        <td>Rp {{ number_format(($d->harga_satuan ?? 0) * ($d->jumlah ?? 0), 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format(optional($d->transaksi)->total_harga ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst(optional($d->transaksi)->metode_pembayaran ?? '-') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <img src="{{ asset('img/Wajah Sedih.png') }}" alt="Frown">
                        <p>Maaf, tidak ada transaksi terbaru</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>