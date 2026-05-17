<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>StocKING - Pengaturan User</title>
    
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
                sans: ['Montserrat', 'sans-serif'],
              }
            }
          }
        }
    </script>

    <style>
        body { 
          background-color: #FFFFFF;
          font-family: 'Montserrat', sans-serif;
        }
        
        .profile-circle {
            width: 150px;
            height: 150px;
            background-color: #00DBFF;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
            color: #333;
            outline: none !important;
        }

        .btn-update-gradient {
            background: linear-gradient(269.3deg, #DBD400 0.01%, #F59E0B 100.01%);
            color: white;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        /* Styling Modal Pop-up */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
        }

        .modal-content {
            background-color: #EDEDED;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 550px;
            width: 100%;
            position: relative;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-white">

<aside class="w-64 border-r border-stocking-border flex flex-col bg-white h-full">
    <div class="p-6">
        <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/>
    </div>
    
    <nav class="flex-1 px-4 mt-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">
            <img alt="Belanja Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Dashboard_Off.png') }}"/> 
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.inventaris') }}" class="flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">
            <img alt="Transaksi Icon" class="w-5 h-5 mr-3 opacity-60" src="{{ asset('img/Inventaris_Off.png') }}"/>
            <span class="text-sm font-medium">Inventaris</span>
        </a>
    </nav>

    <div class="p-4 space-y-2 border-t border-gray-50">
        <a href="{{ route('user.pengaturan') }}" class="flex items-center px-4 py-2 rounded-lg font-semibold text-black shadow-sm"
        style="background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);">
            <img alt="Settings Icon" class="w-5 h-5 mr-3 brightness-0" src="{{ asset('img/Pengaturan_Off.png') }}"/>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>
        
        <button onclick="openLogoutModal()" class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors font-semibold">
            <img alt="Logout Icon" class="w-5 h-5 mr-3 opacity-60 grayscale" src="{{ asset('img/Log out_Off.png') }}"/>
            <span class="text-sm">Log Out</span>
        </button>
    </div>
</aside>

<div class="flex-1 flex flex-col overflow-hidden">
    <header class="h-16 border-b border-stocking-border bg-white flex items-center justify-end px-8">
        <div class="w-10 h-10 rounded-full bg-[#00DBFF] flex items-center justify-center text-white font-bold border border-white shadow-sm overflow-hidden" 
             style="background-image: url('{{ (session('foto') && session('foto') !== 'default.png') ? asset('avatars/' . session('foto')) : '' }}'); background-size: cover; background-position: center;">
            
            @if(!session('foto') || session('foto') === 'default.png')
                <span class="text-white text-lg font-bold">
                    {{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}
                </span>
            @endif
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-10 pb-10 pt-2 bg-white text-left">
        <div class="mb-10">
            <h2 style="color: #151515; font-size: 33.05px;" class="font-bold">Pengaturan</h2>
            <p style="color: #595959;" class="text-sm font-medium">Silahkan Ubah Informasi Pribadi Anda</p>
        </div>

        <div class="w-full">
            <form action="{{ route('user.pengaturan.update_photo') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center justify-center w-full mb-12 space-y-4">
                @csrf
                @method('PUT')
                <input accept="image/*" class="hidden" id="profile-upload" name="foto" type="file" onchange="previewProfile(this)"/>
                
                <div class="profile-circle" id="profile-trigger" onclick="document.getElementById('profile-upload').click()" 
                     style="background-image: url('{{ (session('foto') && session('foto') !== 'default.png') ? asset('avatars/'.session('foto')) : '' }}'); background-size: cover; background-position: center;">
                    
                    @if(!session('foto') || session('foto') === 'default.png')
                        <span id="initials" class="text-white text-5xl font-bold">{{ strtoupper(substr(session('username') ?? 'A', 0, 1)) }}</span>
                    @endif
                </div>
                
                <div class="flex flex-col items-center">
                    <button type="button" class="text-gray-600 font-bold text-lg hover:text-black transition-colors" onclick="document.getElementById('profile-upload').click()">
                        Ganti Foto Profil
                    </button>
                    <button type="submit" id="btn-save-photo" class="btn-update-gradient hidden mt-2">Simpan Foto Baru</button>
                </div>
            </form>

            <div class="flex flex-col w-full max-w-[600px] space-y-3">
                <div>
                    <label class="block text-lg font-bold text-[#151515] mb-2 ml-1">Username</label>
                    <input class="field-input opacity-70" readonly type="text" value="{{ session('username') }}"/>
                    <button type="button" onclick="openModal('usernameModal')" class="btn-update-gradient">Ganti Username</button>
                </div>

                <div> 
                    <label class="block text-lg font-bold text-[#151515] mb-2 ml-1">Password</label>
                    <input class="field-input opacity-70" readonly type="password" value="********"/>
                    <button type="button" onclick="openModal('passwordModal')" class="btn-update-gradient">Ganti Password</button>
                </div>

                <div class="opacity-80">
                    <label class="block text-lg font-bold text-[#151515] mb-2 ml-1">Email</label>
                    <input class="field-input bg-[#F3F4F6] text-gray-500 cursor-not-allowed" readonly type="email" value="{{ session('email') ?? 'admin@stocking.com' }}"/>
                    <p class="text-[#828282] text-xs mt-2 ml-1 italic">*Email akun tidak dapat diubah</p>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="usernameModal" class="modal-backdrop">
    <div class="modal-content">
        <button onclick="closeModal('usernameModal')" class="absolute top-4 right-5 text-2xl text-black hover:opacity-60 transition-opacity">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-[24px] font-extrabold text-[#151515] mb-6">Ganti Username</h3>
        
        <form action="{{ route('user.pengaturan.update_username') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-bold text-[#151515] mb-2">Username Baru</label>
                <input type="text" name="new_username" placeholder="Masukkan username baru anda" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg outline-none focus:border-yellow-500 text-sm placeholder:text-gray-400">
            </div>
            <div>
                <label class="block text-sm font-bold text-[#151515] mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="userPass" name="current_password" placeholder="Masukkan password anda" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg outline-none focus:border-yellow-500 text-sm placeholder:text-gray-400">
                    <button type="button" onclick="togglePass('userPass', 'userEye')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i id="userEye" class="fa-regular fa-eye-slash text-lg"></i>
                    </button>
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#1D1D1D] text-white font-bold py-2.5 px-8 rounded-lg hover:opacity-90 transition-all">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<div id="passwordModal" class="modal-backdrop">
    <div class="modal-content">
        <button onclick="closeModal('passwordModal')" class="absolute top-4 right-5 text-2xl text-black hover:opacity-60 transition-opacity">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-[24px] font-extrabold text-[#151515] mb-6">Ganti Password</h3>
        
        <form action="{{ route('user.pengaturan.update_password') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-[#151515] mb-2">Password Baru</label>
                <div class="relative">
                    <input type="password" id="newPass" name="new_password" placeholder="Masukkan password baru anda" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg outline-none focus:border-yellow-500 text-sm placeholder:text-gray-400">
                    <button type="button" onclick="togglePass('newPass', 'newEye')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i id="newEye" class="fa-regular fa-eye-slash text-lg"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-[#151515] mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="confirmPass" name="current_password" placeholder="Masukkan password anda" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg outline-none focus:border-yellow-500 text-sm placeholder:text-gray-400">
                    <button type="button" onclick="togglePass('confirmPass', 'confirmEye')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i id="confirmEye" class="fa-regular fa-eye-slash text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#1D1D1D] text-white font-bold py-2.5 px-8 rounded-lg hover:opacity-90 transition-all">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<div id="logoutModal" style="display: none;" class="fixed inset-0 z-[100] items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-[#EDEDED] rounded-[20px] p-10 shadow-2xl max-w-sm w-full mx-4 text-center font-sans">
        <h3 class="text-[22px] font-bold text-[#151515] mb-8 leading-tight">Apakah anda yakin ingin keluar?</h3>
        
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28">
                Batal
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-[#1D1D1D] text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition-all w-28">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    function openLogoutModal() { 
        document.getElementById('logoutModal').style.display = 'flex'; 
    }
    function closeLogoutModal() { 
        document.getElementById('logoutModal').style.display = 'none'; 
    }

    window.onclick = function(event) {
        const logoutModal = document.getElementById('logoutModal');
        const userModal = document.getElementById('usernameModal');
        const passModal = document.getElementById('passwordModal');

        if (event.target == logoutModal) closeLogoutModal();
        if (event.target == userModal) closeModal('usernameModal');
        if (event.target == passModal) closeModal('passwordModal');
    }

    function togglePass(inputId, iconId) {
        const passInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            passInput.type = 'password';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    }

    function previewProfile(input) {
        const profileCircle = document.getElementById('profile-trigger');
        const initials = document.getElementById('initials');
        const saveBtn = document.getElementById('btn-save-photo');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileCircle.style.backgroundImage = `url(${e.target.result})`;
                profileCircle.style.backgroundSize = 'cover';
                profileCircle.style.backgroundPosition = 'center';
                if(initials) initials.style.display = 'none';
                saveBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>