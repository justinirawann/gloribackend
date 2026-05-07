@extends('admin.layout')
@section('title', 'Tambah Testimoni')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Tambah Testimoni</h1>
        <p class="text-sm text-slate-500 mt-1">Tambahkan testimoni baru untuk ditampilkan di halaman website.</p>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="admin-btn-secondary inline-flex items-center justify-center px-4 py-3">
        ← Kembali
    </a>
</div>

<div class="admin-card max-w-3xl">
    <div class="admin-card-body">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('admin.testimonials._form', ['portfolios' => $portfolios])
            <div class="flex justify-end">
                <button type="submit" class="admin-btn-warning">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
