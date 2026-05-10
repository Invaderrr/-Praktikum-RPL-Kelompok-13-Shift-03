<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StocKING - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 border-r border-gray-200 flex flex-col bg-white h-full fixed left-0 top-0">
            <div class="p-6">
                <img alt="STOCKING Logo" class="h-8" src="{{ asset('img/STOCKING.png') }}"/>
            </div>

            <nav class="flex-1 px-4 mt-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
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

            <div class="p-4 mt-auto space-y-2">
                <a href="{{ route('admin.pengaturan') }}" 
                class="flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200
                {{ request()->routeIs('admin.pengaturan') ? 'text-black shadow-sm' : 'text-[#828282] hover:text-black hover:bg-gray-50' }}"
                style="{{ request()->routeIs('admin.pengaturan') ? 'background: linear-gradient(93.69deg, rgba(219, 212, 0, 0.5) 0.99%, rgba(245, 158, 11, 0.5) 100%);' : '' }}">
                    <img alt="Settings Icon" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.pengaturan') ? 'brightness-0' : 'opacity-60' }}" src="{{ asset('img/Settings.png') }}"/>
                    <span class="text-sm font-medium">Pengaturan</span>
                </a>

                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-[#828282] hover:bg-gray-50 rounded-lg transition-colors font-semibold">
                        <img alt="Logout Icon" class="w-5 h-5 mr-3" src="{{ asset('img/Logout.png') }}"/>
                        <span class="text-sm">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-white" style="margin-left: 256px;">
            @yield('content')
        </main>
    </div>
</body>
</html>