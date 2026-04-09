@extends('admin.layout')
@section('title', 'Testimonials')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Testimonials</h2>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-warning fw-bold">+ Tambah Testimoni</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Industri</th>
                    <th>Rating</th>
                    <th>Tanggal Proyek</th>
                    <th>Portfolio</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->industry }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $t->rating ? '#FFB500' : '#ccc' }}">★</span>
                        @endfor
                    </td>
                    <td>{{ \Carbon\Carbon::parse($t->project_date)->format('M Y') }}</td>
                    <td>
                        @if($t->portfolio)
                            <span class="badge bg-success">{{ $t->portfolio->name }}</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus testimoni ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada testimoni.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
