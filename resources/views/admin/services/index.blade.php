@extends('admin.layout')

@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Services</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Service
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($services->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-gear" style="font-size: 80px; color: #ddd;"></i>
        <h3 class="mt-3 text-muted">Belum ada service</h3>
        <p class="text-muted">Klik tombol "Tambah Service" untuk menambahkan service pertama</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama Service</th>
                    <th>Banner</th>
                    <th>Deskripsi (ID)</th>
                    <th>Description (EN)</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>
                        @if($service->banner_image)
                            <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Banner" style="height: 50px; width: auto; border-radius: 4px;">
                        @else
                            <span class="text-muted small">No banner</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-primary mb-1">🇮🇩</span>
                        <div class="text-muted small">{{ Str::limit($service->description, 80) }}</div>
                    </td>
                    <td>
                        <span class="badge bg-success mb-1">🇬🇧</span>
                        <div class="text-muted small">{{ Str::limit($service->description_en, 80) }}</div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $service->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Service</label>
                                        <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Banner Image</label>
                                        @if($service->banner_image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Current Banner" style="max-width: 100%; height: auto; border-radius: 4px;">
                                            </div>
                                        @endif
                                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah banner</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi (Indonesia)</label>
                                        <textarea name="description" class="form-control" rows="3" required>{{ $service->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description (English)</label>
                                        <textarea name="description_en" class="form-control" rows="3" required>{{ $service->description_en }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Service</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Indonesia)</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
