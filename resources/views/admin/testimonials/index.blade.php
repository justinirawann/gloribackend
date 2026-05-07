@extends('admin.layout')
@section('title', 'Testimonials')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Testimonials</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola testimoni client yang tampil di website.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="admin-btn-warning inline-flex items-center justify-center px-5 py-3">
        + Tambah Testimoni
    </a>
</div>

<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse text-left text-sm">
            <thead class="bg-slate-900 text-white">
                <tr>
                    <th class="px-5 py-4 font-medium">#</th>
                    <th class="px-5 py-4 font-medium">Nama</th>
                    <th class="px-5 py-4 font-medium">Industri</th>
                    <th class="px-5 py-4 font-medium">Tanggal Proyek</th>
                    <th class="px-5 py-4 font-medium">Portfolio</th>
                    <th class="px-5 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-slate-700">
                @forelse($testimonials as $t)
                <tr class="border-t border-slate-200 hover:bg-slate-50">
                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                    <td class="px-5 py-4">{{ $t->name }}</td>
                    <td class="px-5 py-4">{{ $t->industry }}</td>
                    <td class="px-5 py-4">{{ \Carbon\Carbon::parse($t->project_date)->format('M Y') }}</td>
                    <td class="px-5 py-4">
                        @if($t->portfolio)
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $t->portfolio->name }}</span>
                        @else
                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 space-x-2">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="admin-btn-warning inline-flex items-center justify-center px-3 py-2 text-xs">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus testimoni ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn-danger inline-flex items-center justify-center px-3 py-2 text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada testimoni.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
