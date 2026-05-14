<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StocKING - Belanja</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { background-color: #FFFFFF; font-family: 'Montserrat', sans-serif; }
        
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

        .btn-proses {
            background: linear-gradient(269.79deg, #C86B00 0%, #623400 100%);
        }

        .input-gray {
            background-color: #ECEDED;
            border: 1px solid rgba(0, 0, 0, 0.3);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal.show {
            display: flex;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-white">

<aside class="w-64 border-r border-[#E0E0E0] flex flex-col bg-white">
    <div class="p-6">
        <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/> 
    </div>
    <nav class="flex-1 px-4 mt-4 space-y-2">
        <a href="{{ route('user.belanja') }}" class="flex items-center px-4 py-2 rounded-lg font-semibold text-black shadow-sm" 
            style="background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);">
            <img alt="Belanja Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Belanja.png') }}"/> <span class="text-sm">Belanja</span>
        </a>
        
        <a href="{{ route('user.transaksi') }}" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-all">
            <img alt="Transaksi Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Dollar.png') }}"/> 
            <span class="text-sm font-medium">Transaksi</span>
        </a>
    </nav>

    <div class="p-4 space-y-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">
                <img alt="Logout Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Logout.png') }}"/>
                <span class="text-sm font-medium">Log Out</span>
            </button>
        </form>
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
            <div class="w-10 h-10 rounded-full bg-[#00DBFF] flex items-center justify-center text-white font-bold border border-white shadow-sm"> S </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-6 pb-10 pt-6">
        <div class="flex flex-row gap-6 w-full">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-[#151515]">Belanja</h2>
                <p class="text-gray-500 text-sm mb-6">Halo, Mau Beli Apa Hari Ini?</p>

                <div class="flex justify-between items-center mb-6">
                    <h5 class="text-lg font-bold">Daftar Bahan Baku</h5>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    @forelse($produk as $p)
                    <div class="layer-bottom">
                        <div class="layer-top flex justify-between items-start">
                            <div>
                                <h6 class="font-bold text-sm">{{ $p->nama_item ?? $p->nama_bahan }}</h6>
                                <p class="text-[10px] text-gray-400">{{ $p->kategori }}</p>
                                <p class="text-orange-500 font-bold text-sm mt-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-gray-500">Stok: {{ $p->stok }} {{ $p->satuan }}</p>
                            </div>
                            {{-- Fungsi addToCart menerima data harga dan stok asli dari database --}}
                        
                            <button type="button"
                            onclick="addToCart('{{ $p->getKey() }}', '{{ addslashes($p->nama_item ?? $p->nama_bahan) }}', '{{ $p->harga }}', '{{ $p->stok }}')" 
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white w-7 h-7 rounded-lg font-bold shadow-sm transition-colors">
                                +
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-3 text-center text-gray-400">Data bahan baku tidak ditemukan di database.</p>
                    @endforelse
                </div>
            </div>

            <div class="w-80">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-6 w-full sticky top-0">
                    <div class="flex items-center gap-2 mb-4">
                        <h5 class="font-bold text-lg">Keranjang</h5>
                    </div>

                    <div id="cart-items-list" class="max-h-80 overflow-y-auto">
                        <p class="text-center text-gray-400 text-xs py-8">Keranjang masih kosong, ayo pilih belanjaanmu!</p>
                    </div>
                    
                    <hr class="my-4">

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
                            <span class="font-bold text-lg text-gray-700">Total</span>
                            <span id="total-price-display" class="font-bold text-lg text-orange-600">Rp. 0</span>
                        </div>

                        <button onclick="handlePayment()" class="w-full btn-proses text-white font-bold py-3 rounded-xl mt-2 hover:opacity-90 transition-opacity">
                            Proses Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- Modal QRIS --}}
<div id="qrisModal" class="modal">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl">
        <h5 class="font-bold text-xl mb-2">Pembayaran QRIS</h5>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=StocKING-PAY" class="mx-auto mb-4 border-4 border-gray-50 p-2 rounded-xl">
        <p class="font-bold text-lg">Total: <span id="qris-total-price">Rp. 0</span></p>
        <button onclick="closeModal()" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 rounded-xl mt-6">
            Saya Sudah Bayar
        </button>
    </div>
</div>

{{-- Modal Hapus --}}
<div id="deleteModal" class="modal">
    <div class="bg-white rounded-2xl p-6 w-80 text-center shadow-xl">
        <h3 class="text-lg font-bold text-gray-800">Hapus Item?</h3>
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="flex-1 py-2.5 bg-gray-100 text-gray-600 rounded-xl">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 text-white rounded-xl">Hapus</button>
        </div>
    </div>
</div>

<script>
    let cart = {};
    let itemToDelete = null;

    function addToCart(id, name, price, stock) {
    // Pastikan ID dikonversi ke string agar konsisten sebagai key Object
    const prodId = id.toString();
    
    // Pastikan harga dan stok diubah kembali menjadi angka (Integer)
    const prodPrice = parseInt(price) || 0;
    const prodStock = parseInt(stock) || 0;

    if (!cart[prodId]) {
        cart[prodId] = { 
            name: name, 
            price: prodPrice, 
            qty: 1, 
            stock: prodStock 
        };
    } else {
        if (cart[prodId].qty < prodStock) {
            cart[prodId].qty++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    }
    renderCart();
}
    

    function updateQty(id, change) {
        if (cart[id]) {
            const newQty = cart[id].qty + change;
            if (newQty <= 0) {
                removeFromCart(id);
            } else if (newQty > cart[id].stock) {
                alert('Stok tidak mencukupi!');
            } else {
                cart[id].qty = newQty;
                renderCart();
            }
        }
    }

    function removeFromCart(id) {
        itemToDelete = id;
        document.getElementById('deleteModal').classList.add('show');
        document.getElementById('confirmDeleteBtn').onclick = function() {
            delete cart[itemToDelete];
            closeDeleteModal();
            renderCart();
        };
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        itemToDelete = null;
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
                <div class="flex justify-between items-center mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800">${item.name}</p>
                        <p class="text-xs text-orange-500 font-semibold">Rp ${(item.price).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="updateQty(${id}, -1)" class="w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-600">-</button>
                        <span class="text-sm font-bold w-4 text-center">${item.qty}</span>
                        <button onclick="updateQty(${id}, 1)" class="w-6 h-6 flex items-center justify-center bg-yellow-400 text-white rounded-md">+</button>
                        <button onclick="removeFromCart(${id})" class="ml-2 text-red-400 hover:text-red-600">x</button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html || '<p class="text-center text-gray-400 text-xs py-8">Keranjang masih kosong!</p>';
        totalElement.innerText = 'Rp. ' + total.toLocaleString('id-ID');
    }

    async function handlePayment() {
        const method = document.getElementById('payment-select').value;
        const address = document.getElementById('address-input').value;
        const currentTotal = document.getElementById('total-price-display').innerText;

        if (Object.keys(cart).length === 0) return alert('Keranjang masih kosong!');
        if (!method || method === 'Pilih metode pembayaran') return alert('Pilih metode pembayaran!');
        if (!address.trim()) return alert('Mohon isi alamat pengiriman!');

        if (method === 'qris') {
            document.getElementById('qris-total-price').innerText = currentTotal;
            document.getElementById('qrisModal').classList.add('show');
        } else {
            await sendDataToServer(method, address);
        }
    }

    async function sendDataToServer(metode, alamat) {
        try {
            // Mengambil angka murni dari string tampilan total
            const totalValue = document.getElementById('total-price-display').innerText.replace(/[^0-9]/g, '');

            const response = await fetch("{{ route('user.checkout.proses') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    items: cart,
                    alamat: alamat,
                    metode: metode,
                    total_semua: totalValue 
                })
            });

            const result = await response.json();
            
            if (response.ok && result.success) {
                alert('Pesanan Berhasil!');
                window.location.href = "{{ route('user.transaksi') }}"; 
            } else {
                alert('Gagal: ' + (result.error || 'Terjadi kesalahan sistem'));
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan koneksi ke server.");
        }
    }

    function closeModal() {
        document.getElementById('qrisModal').classList.remove('show');
        const metode = document.getElementById('payment-select').value;
        const alamat = document.getElementById('address-input').value;
        sendDataToServer(metode, alamat);
    }
</script>
</body>
</html>