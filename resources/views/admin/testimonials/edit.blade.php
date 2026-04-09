@extends('admin.layout')
@section('title', 'Edit Testimoni')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Edit Testimoni</h2>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">← Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 700px;">
    <div class="card-body">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.testimonials._form', ['portfolios' => $portfolios, 'testimonial' => $testimonial])
            <button type="submit" class="btn btn-warning fw-bold mt-3">Update</button>
        </form>
    </div>
</div>
@endsection
