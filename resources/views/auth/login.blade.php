<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediStock') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #818cf8;
            box-shadow: 0 0 0 2px rgba(129, 140, 248, 0.2);
            outline: none;
        }
        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }
    </style>
</head>
<body class="font-['Inter'] antialiased bg-[#0B0F19] min-h-screen relative overflow-x-hidden flex items-center justify-center py-12">
    <div class="absolute top-[-20%] left-[-10%] w-[50rem] h-[50rem] bg-indigo-600 rounded-full mix-blend-screen filter blur-[150px] opacity-20 animate-float" style="animation-delay: 0s;"></div>
    <div class="absolute top-[20%] right-[-10%] w-[40rem] h-[40rem] bg-purple-600 rounded-full mix-blend-screen filter blur-[150px] opacity-20 animate-float" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-[-20%] left-[20%] w-[45rem] h-[45rem] bg-blue-600 rounded-full mix-blend-screen filter blur-[150px] opacity-20 animate-float" style="animation-delay: 4s;"></div>
    <div class="w-full max-w-6xl mx-auto p-6 relative z-10 flex flex-col md:flex-row items-center gap-12 lg:gap-24">
        <div class="w-full md:w-1/2 text-white flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-8">
                <h1 class="text-4xl font-bold tracking-tight">Medi<span class="text-indigo-400">Stock</span></h1>
            </div>
            <h2 class="text-5xl lg:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                Manage your stock <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">smarter & faster.</span>
            </h2>
            <p class="text-slate-400 text-lg max-w-md mb-10 leading-relaxed">
                Welcome back! Please log in to your account to view your dashboard, manage products, and track sales performance seamlessly.
            </p>
            <div class="flex items-center gap-4 text-sm text-slate-400 bg-white/5 w-max px-4 py-2 rounded-full border border-white/5">
                <div class="flex -space-x-3">
                    <div class="w-8 h-8 rounded-full border-2 border-[#0B0F19] bg-gradient-to-r from-cyan-400 to-blue-500"></div>
                    <div class="w-8 h-8 rounded-full border-2 border-[#0B0F19] bg-gradient-to-r from-purple-400 to-pink-500"></div>
                    <div class="w-8 h-8 rounded-full border-2 border-[#0B0F19] bg-gradient-to-r from-amber-400 to-orange-500 flex items-center justify-center text-[10px] font-bold text-white">+99</div>
                </div>
                <p>Trusted by modern businesses.</p>
            </div>
        </div>
        <div class="w-full md:w-1/2 max-w-md">
            <div class="glass-panel rounded-[2rem] p-8 md:p-10 shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                <div class="mb-8 relative z-10">
                    <h3 class="text-2xl font-bold text-white mb-2">Sign In</h3>
                    <p class="text-slate-400 text-sm">Enter your credentials to access your account.</p>
                </div>
                <x-auth-session-status class="mb-4 text-emerald-400 bg-emerald-400/10 p-3 rounded-lg text-sm border border-emerald-400/20" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="relative z-10">
                    @csrf
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-400">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                   class="input-glass w-full rounded-xl py-3.5 pl-11 pr-4 text-sm font-medium tracking-wide" placeholder="admin@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm bg-red-400/10 p-2 rounded border border-red-400/20" />
                    </div>
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" 
                                   class="input-glass w-full rounded-xl py-3.5 pl-11 pr-4 text-sm font-medium tracking-wide" placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm bg-red-400/10 p-2 rounded border border-red-400/20" />
                    </div>
                    <div class="mb-8 flex items-center">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <div class="relative flex items-center justify-center w-5 h-5">
                                <input id="remember_me" type="checkbox" class="peer sr-only" name="remember">
                                <div class="absolute inset-0 border border-slate-600 rounded transition-all group-hover:border-indigo-400 bg-white/5 peer-checked:bg-indigo-500 peer-checked:border-indigo-500"></div>
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity absolute pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="ml-3 text-sm text-slate-400 peer-checked:text-slate-300 transition-colors group-hover:text-slate-300">Remember me</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 text-white font-semibold py-3.5 px-4 rounded-xl shadow-[0_0_20px_rgba(99,102,241,0.4)] transform hover:-translate-y-0.5 transition-all duration-200">
                        Sign In to Dashboard
                    </button>
                    @if (Route::has('register'))
                    <div class="mt-8 text-center text-sm text-slate-400">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-white font-medium hover:text-indigo-400 transition-colors underline decoration-white/20 underline-offset-4 hover:decoration-indigo-400">Register here</a>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</body>
</html>