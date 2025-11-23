@extends('layouts.admin')

@section('title', 'Backup & Restore')

@section('content')
<div class="admin-page space-y-8">
    <!-- Header -->
    <div class="admin-header">
        <div class="px-6 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-2xl lg:text-3xl font-bold">Backup & Restore</h1>
                    <p class="text-gray-600 text-sm lg:text-base">Create and manage system backups</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="createBackup()" 
                            class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg"
                            style="background: #FF6F61; color: white;">
                        <i class="fas fa-database mr-2"></i>
                        Create Backup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-lg mb-3">Secure your data with automated backups and easy restore</p>
                <div class="flex items-center space-x-8 text-sm text-gray-500">
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full mr-2" style="background: #FEEA77;"></div>
                        <i class="fas fa-shield-alt mr-2" style="color: #FEEA77;"></i>
                        Data Protection
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full mr-2" style="background: #FEEA77;"></div>
                        <i class="fas fa-history mr-2" style="color: #FEEA77;"></i>
                        Easy Restore
                    </div>
                </div>
            </div>
            <div class="text-5xl" style="color: #FEEA77;">
                <i class="fas fa-database"></i>
            </div>
        </div>
    </div>

        <!-- Backup Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-2xl">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-gray-200 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-database text-2xl"></i>
                    </div>
                    <h3 class="text-gray-800 font-bold text-lg mb-2">Database Backup</h3>
                    <p class="text-gray-600 text-sm">All data including photos, categories, testimonials, and user accounts</p>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-2xl">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-gray-200 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder text-2xl"></i>
                    </div>
                    <h3 class="text-gray-800 font-bold text-lg mb-2">Files Backup</h3>
                    <p class="text-gray-600 text-sm">All uploaded images, thumbnails, and storage files</p>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-2xl">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-gray-200 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-check text-2xl"></i>
                    </div>
                    <h3 class="text-gray-800 font-bold text-lg mb-2">Complete Backup</h3>
                    <p class="text-gray-600 text-sm">Full system backup including database and all files</p>
                </div>
            </div>
        </div>

        <!-- Restore Section -->
        <div class="bg-white border border-gray-200 rounded-2xl mb-8">
            <div class="border-b border-gray-200 pb-6 px-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold flex items-center">
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                            Restore from Backup
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Upload and restore a previous backup</p>
                    </div>
                    <div class="text-gray-600 px-3 py-1 rounded text-xs font-medium">
                        <i class="fas fa-upload mr-1"></i>
                        File Upload
                    </div>
                </div>
            </div>
            <div class="px-6 pt-8 pb-6">
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    <div class="flex-1">
                        <input type="file" id="restore-file" accept=".zip" 
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent">
                    </div>
                    <button onclick="restoreBackup()" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                        <i class="fas fa-history mr-2"></i>
                        Restore
                    </button>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center mr-3 mt-0.5">
                            <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-yellow-800 font-semibold text-sm">Warning</h4>
                            <p class="text-yellow-700 text-sm mt-1">Restoring will overwrite all current data. Make sure to create a backup first!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing Backups -->
        <div class="bg-white border border-gray-200 rounded-2xl">
            <div class="border-b border-gray-200 pb-6 px-6 pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold flex items-center">
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                            Existing Backups
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Manage your backup files</p>
                    </div>
                    @if(count($backups) > 0)
                        <div class="text-gray-600 px-3 py-1 rounded text-xs font-medium">
                            <i class="fas fa-archive mr-1"></i>
                            {{ count($backups) }} Backups
                        </div>
                    @endif
                </div>
            </div>

            @if(count($backups) > 0)
                <div class="px-6 pt-8 pb-6">
                    <div class="space-y-4">
                        @foreach($backups as $backup)
                            <div class="backup-item group relative">
                                <div class="relative bg-white rounded-2xl p-6 border border-gray-200 hover:border-gray-300 transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-gray-200 text-gray-700 rounded-full flex items-center justify-center">
                                                <i class="fas fa-cloud-download-alt text-xl"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-gray-800 font-bold text-lg">{{ $backup['filename'] }}</h4>
                                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                                                    <span class="bg-gray-100 px-3 py-1 rounded-lg">
                                                        <i class="fas fa-weight-hanging mr-1"></i>
                                                        {{ $backup['size'] }}
                                                    </span>
                                                    <span class="bg-gray-100 px-3 py-1 rounded-lg">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $backup['created_at'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.backup.download', $backup['filename']) }}" 
                                               class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-download mr-1"></i>
                                                Download
                                            </a>
                                            <button onclick="deleteBackup('{{ $backup['filename'] }}')" 
                                                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-cloud-download-alt text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">No Backups Found</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">Create your first backup to secure your data.</p>
                    <button onclick="createBackup()" class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-4 rounded-lg font-semibold inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Backup
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center max-w-md mx-4">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
            </div>
            <h3 class="text-gray-800 font-bold text-xl mb-2" id="loading-title">Processing...</h3>
            <p class="text-gray-600" id="loading-message">Please wait while we process your request.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showLoading(title, message) {
    document.getElementById('loading-title').textContent = title;
    document.getElementById('loading-message').textContent = message;
    document.getElementById('loading-modal').classList.remove('hidden');
}

function hideLoading() {
    document.getElementById('loading-modal').classList.add('hidden');
}

function createBackup() {
    showLoading('Creating Backup', 'Please wait while we create a complete backup of your system...');
    
    fetch('{{ route("admin.backup.create") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(async (response) => {
        const text = await response.text();
        try { return JSON.parse(text); } catch(e) { throw new Error(text || 'Non-JSON response'); }
    })
    .then(data => {
        hideLoading();
        if (data.success) {
            showToast('Backup created successfully!', 'success');
            location.reload();
        } else {
            showToast('Failed to create backup: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showToast('An error occurred while creating backup: ' + (error && error.message ? error.message : 'Unknown error'), 'error');
    });
}

function restoreBackup() {
    const fileInput = document.getElementById('restore-file');
    const file = fileInput.files[0];
    
    if (!file) {
        showToast('Please select a backup file to restore', 'info');
        return;
    }
    
    if (!confirm('Are you sure you want to restore this backup? This will overwrite all current data and cannot be undone!')) {
        return;
    }
    
    showLoading('Restoring Backup', 'Please wait while we restore your backup. This may take several minutes...');
    
    const formData = new FormData();
    formData.append('backup_file', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    fetch('{{ route("admin.backup.restore") }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
    .then(async (response) => {
        const text = await response.text();
        try { return JSON.parse(text); } catch(e) { throw new Error(text || 'Non-JSON response'); }
    })
    .then(data => {
        hideLoading();
        if (data.success) {
            showToast('Backup restored successfully! The page will now refresh.', 'success');
            location.reload();
        } else {
            showToast('Failed to restore backup: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showToast('An error occurred while restoring backup: ' + (error && error.message ? error.message : 'Unknown error'), 'error');
    });
}

function deleteBackup(filename) {
    if (!confirm('Are you sure you want to delete this backup? This action cannot be undone.')) {
        return;
    }
    
    fetch(`/admin/backup/${filename}/delete`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Backup deleted successfully!', 'success');
            location.reload();
        } else {
            showToast('Failed to delete backup: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while deleting backup', 'error');
    });
}
</script>
@endpush
@endsection
