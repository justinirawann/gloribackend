@extends('admin.layout')

@section('title', 'Contact Information')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Contact Information</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.contact-info.update') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ $contactInfo->email ?? '' }}" placeholder="info@company.com" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Display Name <span class="text-danger">*</span></label>
                    <input type="text" name="email_name" class="form-control" value="{{ $contactInfo->email_name ?? '' }}" placeholder="info@company.com" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" value="{{ $contactInfo->phone ?? '' }}" placeholder="+62 812 3456 7890" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Display Name <span class="text-danger">*</span></label>
                    <input type="text" name="phone_name" class="form-control" value="{{ $contactInfo->phone_name ?? '' }}" placeholder="+62 812 3456 7890" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">WhatsApp Number</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ $contactInfo->whatsapp ?? '' }}" placeholder="6281234567890">
                    <small class="text-muted">Format: 6281234567890 (tanpa +)</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">WhatsApp Display Name</label>
                    <input type="text" name="whatsapp_name" class="form-control" value="{{ $contactInfo->whatsapp_name ?? '' }}" placeholder="+62 812 3456 7890">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Instagram URL</label>
                    <input type="text" name="instagram" class="form-control" value="{{ $contactInfo->instagram ?? '' }}" placeholder="https://instagram.com/username">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Instagram Display Name</label>
                    <input type="text" name="instagram_name" class="form-control" value="{{ $contactInfo->instagram_name ?? '' }}" placeholder="@username">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ $contactInfo->address ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i>Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
