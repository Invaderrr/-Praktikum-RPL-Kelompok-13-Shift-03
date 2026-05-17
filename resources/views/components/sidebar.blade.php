<aside class="w-64 border-r border-stocking-border flex flex-col bg-white h-full">

    {{-- LOGO --}}
    <div class="p-6">
        <img alt="STOCKING Logo"
             class="h-8"
             src="{{ asset('img/STOCKING.png') }}"/>
    </div>

    {{-- =========================
         MENU ADMIN
    ========================== --}}
    @if(session('role') == 'admin')

    <nav class="flex-1 px-4 mt-4 space-y-2">

        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
           {{ request()->routeIs('admin.dashboard') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('admin.dashboard') ? 'background: linear-gradient(93.69deg, rgba(219,212,0,0.5) 0.99%, rgba(245,158,11,0.5) 100%);' : '' }}">

            <img alt="Home Icon"
                 class="w-5 h-5 mr-3"
                 src="{{ asset('img/Dashboard_Off.png') }}"/>

            <span class="text-sm">Dashboard</span>
        </a>

        {{-- INVENTARIS --}}
        <a href="{{ route('admin.inventaris') }}"
           class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
           {{ request()->routeIs('admin.inventaris') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('admin.inventaris') ? 'background: linear-gradient(93.69deg, rgba(219,212,0,0.5) 0.99%, rgba(245,158,11,0.5) 100%);' : '' }}">

            <img alt="Inventaris Icon"
                 class="w-5 h-5 mr-3"
                 src="{{ asset('img/Inventaris_Off.png') }}"/>

            <span class="text-sm">Inventaris</span>
        </a>

    </nav>

    @endif


    {{-- =========================
         MENU USER
    ========================== --}}
    @if(session('role') == 'user')

    <nav class="flex-1 px-4 mt-4 space-y-2">

        {{-- BELANJA --}}
        <a href="{{ route('user.belanja') }}"
           class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
           {{ request()->routeIs('user.belanja') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('user.belanja') ? 'background: linear-gradient(93.69deg, rgba(219,212,0,0.5) 0.99%, rgba(245,158,11,0.5) 100%);' : '' }}">

            <img alt="Belanja Icon"
                 class="w-5 h-5 mr-3"
                 src="{{ asset('img/Dashboard_Off.png') }}"/>

            <span class="text-sm">Belanja</span>
        </a>

        {{-- TRANSAKSI --}}
        <a href="{{ route('user.transaksi') }}"
           class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
           {{ request()->routeIs('user.transaksi') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
           style="{{ request()->routeIs('user.transaksi') ? 'background: linear-gradient(93.69deg, rgba(219,212,0,0.5) 0.99%, rgba(245,158,11,0.5) 100%);' : '' }}">

            <img alt="Transaksi Icon"
                 class="w-5 h-5 mr-3"
                 src="{{ asset('img/Inventaris_Off.png') }}"/>

            <span class="text-sm">Transaksi</span>
        </a>

        {{-- PENGATURAN --}}
        <a href="{{ route('user.pengaturan') }}"
   class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
   {{ request()->routeIs('user.pengaturan') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
   style="{{ request()->routeIs('user.pengaturan') ? 'background: linear-gradient(93.69deg, rgba(219,212,0,0.5) 0.99%, rgba(245,158,11,0.5) 100%);' : '' }}">
    
    <img alt="Settings Icon" 
         class="w-5 h-5 mr-3 {{ request()->routeIs('user.pengaturan') ? 'brightness-0' : 'opacity-60' }}" 
         src="{{ asset('img/Pengaturan_Off.png') }}"/>
         
    <span class="text-sm font-medium">Pengaturan</span>
</a>

    </nav>

    @endif


    {{-- =========================
         MENU BAWAH
    ========================== --}}
    <div class="p-4 mt-auto space-y-2">

        <form method="GET" action="{{ url('/logout') }}">

            <button type="submit"
                    class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors">

                <img alt="Logout Icon"
                     class="w-5 h-5 mr-3"
                     src="{{ asset('img/Log out_Off.png') }}"/>

                <span class="text-sm font-medium">
                    Log Out
                </span>
            </button>

        </form>

    </div>

</aside>