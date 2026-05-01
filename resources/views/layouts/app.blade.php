<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MediStock') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            
            /* Professional Sidebar Styles */
            .sidebar-bg {
                background: linear-gradient(180deg, #115e59 0%, #0f766e 100%); /* Medical Teal */
                border-right: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 4px 0 24px rgba(13, 148, 136, 0.2);
            }
            
            .nav-item {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                font-weight: 600;
                border-radius: 0.75rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                color: #ccfbf1; /* Very Light Teal */
                margin-bottom: 0.25rem;
            }
            
            .nav-item:hover {
                background-color: rgba(255, 255, 255, 0.15);
                color: #ffffff;
                transform: translateX(4px);
            }
            
            .nav-item-active {
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); /* Bright Teal */
                color: #ffffff !important;
                box-shadow: 0 4px 12px -2px rgba(20, 184, 166, 0.5);
            }
            
            .nav-item-active svg {
                color: #ffffff !important;
            }
            
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.15);
                border-radius: 10px;
                transition: all 0.3s ease;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.25);
            }
            
            /* For Firefox */
            .custom-scrollbar {
                scrollbar-width: thin;
                scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
            }
        </style>
    </head>
    <body class="font-sans antialiased h-full text-slate-900 overflow-hidden" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-900">
            
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- Top Header -->
                <header class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 text-slate-600 dark:text-slate-400 lg:hidden focus:outline-none">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                            <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-indigo-50">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="hidden md:block text-sm font-medium text-slate-700 dark:text-slate-200">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-100" class="absolute right-0 w-48 mt-2 origin-top-right bg-white dark:bg-slate-800 rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Profile Settings</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Heading -->
                @isset($header)
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endisset

                <!-- Main Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
                

            </div>
        </div>
    </body>
</html>

