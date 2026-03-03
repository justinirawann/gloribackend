@extends('admin.layout')

@section('title', 'About Us Images')

@section('content')
<h1 class="mb-4">Manage About Us Images</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <!-- Hero Image -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-image"></i> Hero Image (Top)</h5>
            </div>
            <div class="card-body">
                @if($heroImage && $heroImage->image_path)
                    <img src="{{ asset('storage/' . $heroImage->image_path) }}" class="img-fluid mb-3 rounded" alt="Hero Image">
                @else
                    <div class="alert alert-info">No hero image uploaded yet</div>
                @endif
                
                <form action="{{ route('admin.about-images.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="hero">
                    <div class="mb-3">
                        <label class="form-label">Upload New Hero Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Max 10MB. Recommended: 1920x1080px</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Update Hero Image
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Closing Image -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-image"></i> Closing Image (Bottom)</h5>
            </div>
            <div class="card-body">
                @if($closingImage && $closingImage->image_path)
                    <img src="{{ asset('storage/' . $closingImage->image_path) }}" class="img-fluid mb-3 rounded" alt="Closing Image">
                @else
                    <div class="alert alert-info">No closing image uploaded yet</div>
                @endif
                
                <form action="{{ route('admin.about-images.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="closing">
                    <div class="mb-3">
                        <label class="form-label">Upload New Closing Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Max 10MB. Recommended: 1920x600px</small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Update Closing Image
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
