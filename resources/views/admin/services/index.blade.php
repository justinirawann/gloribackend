@extends('admin.layout')

@section('title', 'Services')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Manage Services</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola daftar layanan yang ditampilkan pada website.</p>
    </div>
    <button type="button" data-modal-open="#addServiceModal" class="admin-btn-primary inline-flex items-center justify-center gap-2 px-5 py-3">
        <span>+ Add Service</span>
    </button>
</div>

@if(session('success'))
    <div class="admin-alert admin-alert-success mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="admin-alert admin-alert-error mb-4">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="admin-alert admin-alert-error mb-4">
        <ul class="list-disc list-inside space-y-1 mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($services->isEmpty())
    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center">
        <div class="mx-auto mb-5 inline-flex h-24 w-24 items-center justify-center rounded-full bg-slate-100 text-5xl text-slate-400">⚙️</div>
        <h3 class="text-xl font-semibold text-slate-900">No services yet</h3>
        <p class="mt-2 text-sm text-slate-500">Click &ldquo;Add Service&rdquo; button to add your first service.</p>
    </div>
@else
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Service Name</th>
                        <th class="px-6 py-4 font-semibold">Banner</th>
                        <th class="px-6 py-4 font-semibold">Description</th>
                        <th class="px-6 py-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-slate-700">
                    @foreach($services as $service)
                    <tr class="border-t border-slate-200 hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $service->name }}</td>
                        <td class="px-6 py-4">
                            @if($service->banner_image)
                                <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Banner" class="h-12 w-auto rounded-lg object-cover" />
                            @else
                                <span class="text-sm text-slate-500">No banner</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($service->description, 120) }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <button type="button" data-modal-open="#editServiceModal{{ $service->id }}" class="admin-btn-warning inline-flex items-center justify-center px-3 py-2 text-xs">
                                Edit
                            </button>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn-danger inline-flex items-center justify-center px-3 py-2 text-xs" onclick="return confirm('Yakin hapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@foreach($services as $service)
<div class="admin-modal hidden items-center justify-center bg-slate-900/60 p-4" id="editServiceModal{{ $service->id }}" style="display:none;">
    <div class="w-full max-w-3xl rounded-[26px] bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h5 class="text-lg font-semibold text-slate-900">Edit Service</h5>
            <button type="button" data-modal-close class="text-slate-500 hover:text-slate-900">×</button>
        </div>
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
            @csrf
            <div>
                <label class="admin-form-label">Service Name</label>
                <input type="text" name="name" class="admin-form-input" value="{{ $service->name }}" required>
            </div>
            <div>
                <label class="admin-form-label">Banner Image</label>
                @if($service->banner_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Current Banner" class="max-h-44 w-full rounded-2xl object-cover" />
                    </div>
                @endif
                <input type="file" name="banner_image" class="admin-form-input" accept="image/*">
                <p class="mt-2 text-sm text-slate-500">Leave empty if you don't want to change the banner.</p>
            </div>
            <div>
                <label class="admin-form-label">Description</label>
                <textarea name="description" class="admin-form-input min-h-[140px]" rows="4" required>{{ $service->description }}</textarea>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="admin-btn-secondary">Cancel</button>
                <button type="submit" class="admin-btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="admin-modal hidden items-center justify-center bg-slate-900/60 p-4" id="addServiceModal" style="display:none;">
    <div class="w-full max-w-3xl rounded-[26px] bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h5 class="text-lg font-semibold text-slate-900">Add Service</h5>
            <button type="button" data-modal-close class="text-slate-500 hover:text-slate-900">×</button>
        </div>
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
            @csrf
            <div>
                <label class="admin-form-label">Service Name</label>
                <input type="text" name="name" class="admin-form-input" required>
            </div>
            <div>
                <label class="admin-form-label">Banner Image</label>
                <input type="file" name="banner_image" class="admin-form-input" accept="image/*">
            </div>
            <div>
                <label class="admin-form-label">Description</label>
                <textarea name="description" class="admin-form-input min-h-[140px]" rows="4" required></textarea>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="admin-btn-secondary">Cancel</button>
                <button type="submit" class="admin-btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
