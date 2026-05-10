<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>StocKING - Pengaturan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                'stocking-yellow': '#F2C94C',
                'stocking-border': '#E0E0E0',
              },
              fontFamily: {
                // Set default font ke Montserrat [cite: 41, 43]
                sans: ['Montserrat', 'sans-serif'],
              }
            }
          }
        }
    </script>

    <style>
        body { 
            background-color: #FFFFFF;
            font-family: 'Montserrat', sans-serif; /* [cite: 43] */
        }
        
        .profile-circle {
            width: 150px;
            height: 150px;
            background-color: #00DBFF; /* Warna Cyan [cite: 45] */
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .profile-circle:hover { opacity: 0.8; transform: scale(1.02); }

        .field-input {
            background-color: #F9F9F9 !important;
            border: 1px solid #E5E7EB !important;
            border-radius: 12px !important;
            padding: 0 16px;
            width: 100% !important;
            max-width: 600px !important;
            height: 56px !important;
            font-size: 1rem;
            color: #828282;
            outline: none !important;
            transition: border 0.2s;
        }
        .field-input:focus { border: 1px solid #F2C94C !important; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-white">

<aside class="w-64 border-r border-stocking-border flex flex-col bg-white">
    <div class="p-6">
        <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/>
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
           {{ request()->routeIs('admin.inventaris') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('admin.inventaris') ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' : '' }}">
            <img alt="Inventaris Icon" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.inventaris') ? 'brightness-0' : 'opacity-60 grayscale' }}" src="{{ asset('img/Inventoris.png') }}"/> 
            <span class="text-sm">Inventaris</span>
        </a>
    </nav>

    <div class="p-4 space-y-2 border-t border-gray-50">
        <a href="{{ route('admin.pengaturan') }}" 
           class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200 
           {{ request()->routeIs('admin.pengaturan') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('admin.pengaturan') ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' : '' }}">
            <img alt="Settings Icon" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.pengaturan') ? 'brightness-0' : 'opacity-60 grayscale' }}" src="{{ asset('img/Settings.png') }}"/>
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

        <div class="flex items-center space-x-6">
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
        <div class="mb-4">
            <h2 style="color: #151515; font-size: 33.05px;" class="font-bold">Pengaturan</h2>
            <p style="color: #595959;" class="text-sm">Kelola Informasi Pribadi Anda</p>
        </div>

        <div class="flex flex-col items-center justify-center mb-12 space-y-4">
            <input accept="image/*" class="hidden" id="profile-upload" type="file"/>
            <div class="profile-circle" id="profile-trigger" onclick="document.getElementById('profile-upload').click()"></div>
            <button class="text-gray-600 font-bold text-lg hover:text-black transition-colors" onclick="document.getElementById('profile-upload').click()">
                Ganti Foto Profil
            </button>
        </div>

        <div class="flex flex-col w-full max-w-[600px]">
            <div class="mb-5">
                <label class="block text-lg font-bold text-[#151515] mb-2 ml-1">Username</label>
                <input class="field-input cursor-default" readonly type="text" value="Admin123"/>
            </div>

            <div> 
                <label class="block text-lg font-bold text-[#151515] mb-2 ml-1">Password</label>
                <div class="relative w-full">
                    <input class="field-input cursor-default pr-12" id="password" readonly type="password" value="Admin123"/>
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors" id="togglePassword" type="button">
                        <i class="fa-regular fa-eye text-xl"></i>
                    </button>
                </div>
            </div>

            <p class="text-[#828282] text-[15px] mt-2 ml-1">
                *Hubungi teknisi untuk mengubah username dan password
            </p>
        </div>
    </main>
</div>

<script>
    // Logic Toggle Password [cite: 68]
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    toggleBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = toggleBtn.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Logic Preview Foto Profil [cite: 69, 72]
    const fileInput = document.getElementById('profile-upload');
    const profileCircle = document.getElementById('profile-trigger');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileCircle.style.backgroundImage = `url(${e.target.result})`;
                profileCircle.style.backgroundSize = 'cover';
                profileCircle.style.backgroundPosition = 'center';
            }
            reader.readAsDataURL(file);
        }
    });

    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        document.getElementById('logoutModal').classList.add('flex');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
        document.getElementById('logoutModal').classList.remove('flex');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('logoutModal');
        if (event.target == modal) {
            closeLogoutModal();
        }
    }
</script>

<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-[#EDEDED] rounded-[20px] p-10 shadow-2xl max-w-sm w-full mx-4 text-center font-sans">
        <h3 class="text-[22px] font-bold text-[#151515] mb-8 leading-tight">Apakah anda yakin ingin keluar?</h3>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28">Batal</button>
            <a href="{{ url('/') }}" class="bg-[#1D1D1D] text-white font-bold py-2 px-2 rounded-lg hover:opacity-90 transition-all w-28 text-center">Konfirmasi</a>
        </div>
    </div>
</div>
</body>
</html>