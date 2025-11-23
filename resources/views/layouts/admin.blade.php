<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Maravia') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-teal.css') }}" rel="stylesheet">
    <style>
        .modern-toast { border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); color: #1C1C1C; background: #fff; }
        .modern-toast.success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .modern-toast.error { background: #FF6F61; color: #fff; border: 1px solid #ffb3ab; }
        .modern-toast.info { background: #FEEA77; color: #1C1C1C; border: 1px solid #FCD34D; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 modern-sidebar flex flex-col">
            <!-- Logo -->
            <div class="modern-logo-section">
                <div class="flex items-center space-x-3">
                    <div class="modern-logo overflow-hidden rounded-lg">
                        <!-- Logo Foto Bunga Mawar -->
                        <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><radialGradient id="rose" cx="50%" cy="40%" r="60%"><stop offset="0%" stop-color="#fbbf24"/><stop offset="30%" stop-color="#f59e0b"/><stop offset="60%" stop-color="#dc2626"/><stop offset="80%" stop-color="#b91c1c"/><stop offset="100%" stop-color="#7f1d1d"/></radialGradient><radialGradient id="leaf" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#65a30d"/><stop offset="100%" stop-color="#166534"/></radialGradient></defs><ellipse cx="50" cy="85" rx="20" ry="10" fill="url(#leaf)" opacity="0.8"/><ellipse cx="30" cy="80" rx="15" ry="8" fill="url(#leaf)" opacity="0.6"/><path d="M50 15 C25 20, 20 40, 30 65 C35 55, 40 50, 50 55 C60 50, 65 55, 70 65 C80 40, 75 20, 50 15 Z" fill="url(#rose)" opacity="0.95"/><path d="M50 20 C30 25, 28 42, 35 58 C38 50, 42 47, 50 50 C58 47, 62 50, 65 58 C72 42, 70 25, 50 20 Z" fill="url(#rose)" opacity="0.9"/><path d="M50 25 C38 28, 36 40, 42 52 C44 47, 46 45, 50 47 C54 45, 56 47, 58 52 C64 40, 62 28, 50 25 Z" fill="url(#rose)"/><circle cx="50" cy="42" r="6" fill="#fbbf24" opacity="0.9"/><circle cx="50" cy="42" r="3" fill="#f59e0b"/><ellipse cx="46" cy="38" rx="3" ry="4" fill="#fecaca" opacity="0.7"/><ellipse cx="52" cy="40" rx="2" ry="3" fill="#fecaca" opacity="0.5"/></svg>') }}" 
                             alt="Maravia Logo" 
                             class="w-6 h-6 object-cover">
                    </div>
                    <div>
                        <h2 class="modern-title">Maravia</h2>
                        <p class="modern-subtitle">Admin Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="modern-nav flex-1">
                <a href="{{ route('admin.dashboard') }}" class="modern-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.photos.index') }}" class="modern-nav-item {{ request()->routeIs('admin.photos.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>Photos</span>
                </a>



                <a href="{{ route('admin.articles.index') }}" class="modern-nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Articles</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="modern-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.tags.index') }}" class="modern-nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Tags</span>
                </a>

                <a href="{{ route('admin.comments.index') }}" class="modern-nav-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Comments</span>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="modern-nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Testimonials</span>
                </a>

                

                <hr class="modern-divider">

                <a href="{{ route('admin.backup.index') }}" class="modern-nav-item {{ request()->routeIs('admin.backup*') ? 'active' : '' }}">
                    <i class="fas fa-download"></i>
                    <span>Backup</span>
                </a>

                
            </nav>

            <!-- User Info -->
            <div class="modern-user-section">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="modern-user-avatar">
                        <span>{{ substr((\Illuminate\Support\Facades\Auth::guard('admin')->user()?->name ?? 'A'), 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="truncate text-sm font-medium text-white">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()?->name ?? 'Guest' }}</p>
                        <p class="text-xs truncate text-white opacity-80">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()?->email ?? '' }}</p>
                    </div>
                </div>

                <div class="flex space-x-2 mt-3">
                    <a href="{{ route('home') }}" target="_blank" 
                       class="flex-1 text-center px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-1"
                       style="background: #A3D5FF; color: #1C1C1C;">
                        <i class="fas fa-external-link-alt text-xs"></i>
                        View Site
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-1"
                                style="background: #A3D5FF; color: #1C1C1C;">
                            <i class="fas fa-sign-out-alt text-xs"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="modern-main-content">
            @yield('content')
        </div>
    </div>

    <!-- Toast Notifications -->
    @if(session('success'))
        <div id="toast-success" class="modern-toast success fixed top-4 right-4 px-6 py-3 z-50 transform transition-transform duration-300">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error" class="modern-toast error fixed top-4 right-4 px-6 py-3 z-50 transform transition-transform duration-300">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div id="toast-info" class="modern-toast info fixed top-4 right-4 px-6 py-3 z-50 transform transition-transform duration-300">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-3a1 1 0 100-2 1 1 0 000 2zm1 8V9H9v6h2z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('info') }}</span>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirm-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 max-w-md mx-auto mt-40 bg-white rounded-2xl shadow-2xl p-6">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#FF6F61;color:white;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Confirm Deletion</h3>
                    <p id="delete-confirm-message" class="text-sm text-gray-600">Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="delete-cancel-btn" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Cancel</button>
                <button type="button" id="delete-confirm-btn" class="px-4 py-2 rounded-lg text-white" style="background:#FF6F61;">Delete</button>
            </div>
            <form id="delete-hidden-form" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
            </form>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Auto-hide toast notifications
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('[id^="toast-"]');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            });

            // Global toast helper
            window.showToast = function(message, type = 'success', duration = 4000) {
                const containerId = 'toast-stack';
                let container = document.getElementById(containerId);
                if (!container) {
                    container = document.createElement('div');
                    container.id = containerId;
                    container.className = 'fixed top-4 right-4 z-50 space-y-2';
                    document.body.appendChild(container);
                }

                const el = document.createElement('div');
                el.className = `modern-toast ${type} px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300`;

                const wrap = document.createElement('div');
                wrap.className = 'flex items-center space-x-2';
                const span = document.createElement('span');
                span.textContent = message || '';
                wrap.appendChild(span);
                el.appendChild(wrap);
                container.appendChild(el);

                setTimeout(() => {
                    el.style.transform = 'translateX(100%)';
                    setTimeout(() => el.remove(), 300);
                }, Math.max(1000, duration || 4000));
            };

            // Delete modal wiring
            const modal = document.getElementById('delete-confirm-modal');
            const msgEl = document.getElementById('delete-confirm-message');
            const cancelBtn = document.getElementById('delete-cancel-btn');
            const confirmBtn = document.getElementById('delete-confirm-btn');
            const form = document.getElementById('delete-hidden-form');

            window.showDeleteModal = function(options) {
                const { message, action, method } = options || {};
                msgEl.textContent = message || 'Are you sure you want to delete this item? This action cannot be undone.';
                form.setAttribute('action', action);
                const methodInput = form.querySelector('input[name="_method"]');
                methodInput.value = (method || 'DELETE').toUpperCase();
                modal.classList.remove('hidden');
            };

            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
            confirmBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                form.submit();
            });
        });
    </script>
</body>
</html>
