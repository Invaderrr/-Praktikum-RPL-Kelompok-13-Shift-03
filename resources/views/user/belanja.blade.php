<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>StocKING - Belanja</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { background-color: #FFFFFF; font-family: 'Montserrat', sans-serif; }
        
        /* Efek Tumpuk Kartu */
        .layer-bottom {
            background: #FEF3C7;
            border-radius: 12px;
            position: relative;
            padding-bottom: 5px;
        }
        .layer-top {
            background: #FFFFFF;
            border: 1px solid rgba(230, 230, 230, 0.3);
            border-radius: 12px;
            position: relative;
            top: -5px;
            padding: 12px;
        }

        /* Gradasi Tombol Sesuai Ketentuan */
        .btn-proses {
            background: linear-gradient(269.79deg, #C86B00 0%, #623400 100%);
        }

        /* Dropdown & Input Style */
        .input-gray {
            background-color: #ECEDED;
            border: 1px solid rgba(0, 0, 0, 0.3);
        }

        /* Tambahkan ini di bagian <style> */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Gelap di belakang */
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1.5rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-white">

<aside class="w-64 border-r border-[#E0E0E0] flex flex-col bg-white">
    <div class="p-6">
        <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/> 
    </div>
    <nav class="flex-1 px-4 mt-4 space-y-2">
        <a href="#" class="flex items-center px-4 py-2 rounded-lg font-semibold text-black shadow-sm" 
            style="background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);">
            <img alt="Belanja Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Belanja.png') }}"/> <span class="text-sm">Belanja</span>
        </a>

        <a href="#" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-all">
        <img alt="Transaksi Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Dollar.png') }}"/> 
        <span class="text-sm font-medium">Transaksi</span>
    </a>
    </nav>

    <div class="p-4 space-y-2">
        <a class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors" href="#">
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
    <header class="h-16 border-b border-[#E0E0E0] bg-white flex items-center justify-between px-8">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <input class="w-full pl-4 pr-10 py-1.5 border border-[#E0E0E0] rounded-lg text-sm outline-none" placeholder="Search" type="text"/>
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
                S </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-6 pb-10 pt-6">
        <div class="flex flex-row gap-6 w-full">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-[#151515]">Belanja</h2>
                <p class="text-gray-500 text-sm mb-6">Halo, Mau Beli Apa Hari Ini?</p>

                <div class="flex justify-between items-center mb-6">
                    <h5 class="text-lg font-bold">Daftar Bahan Baku</h5>
                    <select class="input-gray pl-4 pr-10 py-1.5 rounded-lg text-sm font-semibold outline-none appearance-none cursor-pointer">
                        <option>Semua Kategori</option>
                        <option>Bahan Kering</option>
                        <option>Bumbu</option>
                        <option>Nabati</option>
                        <option>Hewani</option>
                        <option>Bahan Masak</option>
                        <option>Frozen Food</option>
                        <option>Minuman</option>
                        <option>Instan</option>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-6">
    @foreach($produk as $p)
    <div class="layer-bottom">
        <div class="layer-top flex justify-between items-start">
            <div>
                <h6 class="font-bold text-sm">{{ $p->nama_item }}</h6>
                <p class="text-[10px] text-gray-400">{{ $p->kategori }}</p>
                <p class="text-orange-500 font-bold text-sm mt-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                <p class="text-[10px] text-gray-500">Stok: {{ $p->stok }} {{ $p->satuan }}</p>
            </div>
            
            <button onclick="addToCart({{ $p->id }}, '{{ $p->nama_item }}', {{ $p->harga }}, {{ $p->stok }})" 
                    class="bg-yellow-400 text-white w-7 h-7 rounded-lg font-bold shadow-sm">
                +
            </button>
        </div>
    </div>
    @endforeach
</div>

            <div class="flex-1">
    <div class="flex-1 mt-8"> <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-6 w-full">
        <div class="flex items-center gap-2 mb-4">
            <img src="{{ asset('img/Keranjang.png') }}" class="w-5 h-5" alt="">
            <h5 class="font-bold text-lg">Keranjang</h5>
        </div>

        <div id="cart-items-list">
            <p class="text-center text-gray-400 text-xs py-8">Keranjang masih kosong, ayo pilih belanjaanmu!</p>
        </div>
        
        <hr class="mb-4">

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold mb-1">Metode Pembayaran</label>
                <select id="payment-select" class="w-full input-gray p-2.5 rounded-xl text-sm outline-none cursor-pointer">
                    <option disabled selected>Pilih metode pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">Alamat</label>
                <textarea id="address-input" class="w-full input-gray p-3 rounded-xl text-sm outline-none" rows="3" placeholder="Masukkan alamat lengkap pengiriman"></textarea>
            </div>

            <div class="flex justify-between items-center pt-4">
                <span class="font-bold text-lg">Total</span>
                <span id="total-price-display" class="font-bold text-lg">Rp. 0</span>
            </div>

            <button onclick="handlePayment()" class="w-full btn-proses text-white font-bold py-3 rounded-xl mt-2">
                Proses Pembayaran
            </button>
        </div>
    </div>
</div>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cart = {};

    function addToCart(id, name, price, stock) {
        if (!cart[id]) {
            cart[id] = { name: name, price: price, qty: 1, stock: stock };
        } else {
            if (cart[id].qty < stock) {
                cart[id].qty++;
            } else {
                alert('Stok tidak mencukupi!');
            }
        }
        renderCart();
    }

    // Fungsi untuk menambah atau mengurangi jumlah
    function updateQty(id, change) {
        if (cart[id]) {
            const newQty = cart[id].qty + change;
            if (newQty <= 0) {
                removeFromCart(id); // Akan memicu pop-up konfirmasi
            } else if (newQty > cart[id].stock) {
                alert('Stok tidak mencukupi!');
            } else {
                cart[id].qty = newQty;
                renderCart();
            }
        }
    }

// Fungsi untuk menghapus item sepenuhnya
    let itemToDelete = null; // Variabel bantuan untuk menyimpan ID sementara

    function removeFromCart(id) {
        itemToDelete = id; // Simpan ID barang yang mau dihapus
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden'); // Munculkan pop-up modal
        
        // Logika ketika tombol "Hapus" di dalam modal diklik
        document.getElementById('confirmDeleteBtn').onclick = function() {
            delete cart[itemToDelete]; // Hapus barang dari keranjang
            closeDeleteModal();        // Tutup modalnya
            renderCart();             // Update tampilan keranjang
        };
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden'); // Sembunyikan kembali modalnya
        itemToDelete = null;           // Reset ID bantuan
    }

        function renderCart() {
        const container = document.getElementById('cart-items-list');
        const totalElement = document.getElementById('total-price-display');
        let html = '';
        let total = 0;

    Object.keys(cart).forEach(id => {
        const item = cart[id];
        total += item.price * item.qty;
        html += `
            <div class="flex justify-between items-center mb-4 bg-gray-50 p-3 rounded-xl">
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800">${item.name}</p>
                    <p class="text-xs text-orange-500 font-semibold">Rp ${(item.price).toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="updateQty(${id}, -1)" class="w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600 hover:bg-gray-100">-</button>
                    
                    <span class="text-sm font-bold w-4 text-center">${item.qty}</span>
                    
                    <button onclick="updateQty(${id}, 1)" class="w-6 h-6 flex items-center justify-center bg-yellow-400 text-white rounded-md hover:bg-yellow-500">+</button>
                    
                    <button onclick="removeFromCart(${id})" class="ml-2 text-red-400 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        `;
    });

    container.innerHTML = html || '<p class="text-center text-gray-400 text-xs py-8">Keranjang masih kosong, ayo pilih belanjaanmu!</p>';
    totalElement.innerText = 'Rp. ' + total.toLocaleString('id-ID');
    }

    // Fungsi Utama Pembayaran
    async function handlePayment() {
        const method = document.getElementById('payment-select').value;
        const address = document.getElementById('address-input').value;
        const currentTotal = document.getElementById('total-price-display').innerText;

        // Validasi
        if (Object.keys(cart).length === 0) return alert('Keranjang masih kosong!');
        if (method === 'Pilih metode pembayaran' || !method) return alert('Pilih metode pembayaran dulu!');
        if (!address) return alert('Mohon isi alamat pengiriman!');

        if (method === 'qris') {
            document.getElementById('qris-total-price').innerText = currentTotal;
            document.getElementById('qrisModal').classList.add('show');
            // Proses ke server dilakukan setelah tombol "Saya Sudah Bayar" diklik
        } else {
            // Jika Cash, langsung kirim ke server
            await sendDataToServer(method, address);
        }
    }

    // Fungsi Terpisah untuk Kirim Data ke Laravel
    async function sendDataToServer(metode, alamat) {
    try {
        // 1. Hitung totalValue DULU sebelum fetch
        const totalValue = document.getElementById('total-price-display').innerText.replace(/[^0-9]/g, '');

        // 2. Baru panggil fetch
        const response = await fetch("{{ route('user.checkout.proses') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                items: cart,
                alamat: alamat,   // Menggunakan parameter 'address' dari fungsi
                metode: metode,    // Menggunakan parameter 'method' dari fungsi
                total_semua: totalValue 
            })
        });
        // 3. Tambahkan pengecekan hasil
        const result = await response.json();
        if (response.ok) {
            alert('Pesanan Berhasil!');
            location.reload(); 
        } else {
            alert('Gagal: ' + (result.message || 'Terjadi kesalahan'));
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan koneksi.");
    }
} // <-- Tutup fungsi di sini

    function closeModal() {
        document.getElementById('qrisModal').classList.remove('show');
        // Panggil pengiriman data setelah user menutup modal QRIS
        const metode = document.getElementById('payment-select').value;
        const alamat = document.getElementById('address-input').value;
        sendDataToServer(metode, alamat);
    }
</script>

<div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center">
            <h5 class="font-bold">Pembayaran QRIS</h5>
            <p class="text-muted small">Silakan scan barcode di bawah ini</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=StocKING-PAY" class="mx-auto my-3" width="200">
            <p class="fw-bold">Total: <span id="qris-total-price">Rp. 0</span></p>
            <button onclick="closeModal()" class="w-full bg-yellow-400 text-black font-bold py-3 rounded-xl mt-4">
                Saya Sudah Bayar
            </button>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-2xl p-6 w-80 text-center shadow-xl">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Hapus Item?</h3>
        <p class="text-sm text-gray-500 mt-2">Apakah kamu yakin ingin menghapus barang ini dari keranjang?</p>
        
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="flex-1 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-semibold hover:bg-gray-200 transition-all">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-all shadow-md">Hapus</button>
        </div>
    </div>
</div>

</body>
</html>