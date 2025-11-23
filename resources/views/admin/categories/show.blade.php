@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="admin-page space-y-8">
    <!-- Header -->
    <div class="admin-header">
        <div class="px-6 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-2xl lg:text-3xl font-bold">Category: {{ $category->name }}</h1>
                    <p class="text-gray-600 text-sm lg:text-base">Overview and recent photos in this category</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg" style="background: #A3D5FF; color: #1C1C1C;">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Categories
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg bg-amber-400 text-white">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 pb-8 space-y-8">
        <!-- Category Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg" style="background: {{ $category->color ?? '#FEEA77' }}33;">
                            <i class="{{ $category->icon ?? 'fas fa-folder' }} text-amber-600"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $category->name }}</h2>
                        @if($category->is_active)
                            <span class="inline-block text-xs px-3 py-1 rounded-full font-medium" style="background: #9DE4B3; color: #1C1C1C;">
                                <i class="fas fa-check mr-1"></i>Active
                            </span>
                        @else
                            <span class="inline-block text-xs px-3 py-1 rounded-full font-medium bg-red-500 text-white">
                                <i class="fas fa-pause mr-1"></i>Inactive
                            </span>
                        @endif
                    </div>
                    @if($category->description)
                        <p class="text-gray-600">
                            {{ $category->description }}
                        </p>
                    @endif
                    <div class="text-sm text-gray-500">
                        <span class="mr-4"><i class="fas fa-link mr-1"></i>Slug: {{ $category->slug }}</span>
                        <span><i class="fas fa-calendar mr-1"></i>Created: {{ $category->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Photos -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Photos</h3>
                <span class="text-sm text-gray-500">Showing up to 12 photos</span>
            </div>
            @if($category->photos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($category->photos as $photo)
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <img src="{{ $photo->url }}" alt="{{ $photo->title }}" class="w-full h-44 object-cover">
                            <div class="p-3">
                                <div class="font-medium text-gray-800 truncate">{{ $photo->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-eye mr-1"></i>{{ $photo->view_count ?? 0 }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $photo->created_at->format('M j') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    No photos yet in this category.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
