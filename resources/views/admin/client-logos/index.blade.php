@extends('admin.layout')

@section('title', 'Client Logos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Client Logos</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Logo
    </button>
</div>

@if($logos->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-image" style="font-size: 80px; color: #ddd;"></i>
        <h3 class="mt-3 text-muted">Belum ada logo client</h3>
        <p class="text-muted">Klik tombol "Tambah Logo" untuk menambahkan logo client pertama</p>
    </div>
@else
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
        @foreach($logos as $logo)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $logo->image_path) }}" class="card-img-top p-3" alt="Client Logo" style="height: 150px; object-fit: contain; background: #f8f9fa;">
                <div class="card-body p-2">
                    <form action="{{ route('admin.client-logos.destroy', $logo) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin hapus?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.client-logos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Logo Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Logo Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
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
