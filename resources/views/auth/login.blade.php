@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Login</h2>
            <p class="text-gray-600">Masuk untuk mengelola galeri foto</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2" style="color: #F62731;"></i>
                        Email Address
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror" style="--tw-ring-color: #F62731;" 
                               placeholder="contoh: marivia@example.com"
                               value="{{ old('email') }}">
                        @error('email')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                        @enderror
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-times-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2" style="color: #F62731;"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror" style="--tw-ring-color: #F62731;" 
                               placeholder="contoh: mamarivia">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-times-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Demo Info -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 border-gray-300 rounded" style="color: #F62731; --tw-ring-color: #F62731;">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white transition-all duration-300 transform hover:scale-105" style="background: linear-gradient(135deg, #F62731, #EE5158); --tw-ring-color: #F62731;">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-red-200 group-hover:text-red-100"></i>
                        </span>
                        Masuk ke Dashboard
                    </button>
                </div>
                <!-- Register Link -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-coral-600 hover:text-coral-500">Daftar sekarang</a>
                    </p>
                </div>
                
            </form>
        </div>

        
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Add floating animation to features
    document.addEventListener('DOMContentLoaded', function() {
        const features = document.querySelectorAll('.grid > div');
        features.forEach((feature, index) => {
            feature.style.animationDelay = `${index * 0.2}s`;
            feature.classList.add('animate-float');
        });
    });
</script>
@endpush

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .bg-white\/50 {
        background-color: rgba(255, 255, 255, 0.5);
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    .border-white\/20 {
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>
@endpush
