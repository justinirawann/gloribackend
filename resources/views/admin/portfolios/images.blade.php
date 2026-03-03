@extends('admin.layout')

@section('title', 'Manage Portfolio Images')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Portfolios
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">{{ $portfolio->name }} - Images</h4>
        <small>Service: {{ $portfolio->service->name }} | Category: {{ $portfolio->category }}</small>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Upload Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-cloud-upload"></i> Upload Images</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.portfolios.images.upload', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                <small class="text-muted">Max 10MB per image. You can select multiple images.</small>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload"></i> Upload Images
            </button>
        </form>
    </div>
</div>

<!-- Display Selection Section -->
<div class="card mb-4">
    <div class="card-header bg-warning">
        <h5><i class="bi bi-star"></i> Select 5 Images to Display (Drag to Reorder)</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.portfolios.images.display', $portfolio) }}" method="POST" id="displayForm">
            @csrf
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Select exactly 5 images to display on the frontend. Drag to change order (1-5).
            </div>
            
            <div id="selectedImages" class="d-flex flex-wrap gap-3 mb-3" style="min-height: 200px; border: 2px dashed #ccc; padding: 15px; border-radius: 8px; overflow-x: auto;">
                @if($portfolio->displayedImages->isEmpty())
                    <p class="text-muted text-center w-100 m-0">Click images below to select 5 images, then drag here to reorder</p>
                @else
                    @foreach($portfolio->displayedImages as $img)
                        <div data-image-id="{{ $img->id }}" style="cursor: move; flex-shrink: 0;">
                            <div class="card border-success" style="width: 150px;">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="card-img-top" style="height: 150px; width: 150px; object-fit: cover;">
                                <div class="card-body text-center p-2">
                                    <span class="badge bg-success">{{ $img->display_order }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-success" id="saveDisplayBtn" disabled>
                <i class="bi bi-check-circle"></i> Save Display Order
            </button>
        </form>
    </div>
</div>

<!-- All Images Gallery -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-images"></i> All Images ({{ $portfolio->images->count() }})</h5>
        @if($portfolio->images->count() > 0)
            <form action="{{ route('admin.portfolios.images.deleteAll', $portfolio) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete ALL images from this portfolio? This cannot be undone!')">
                    <i class="bi bi-trash3"></i> Delete All Images
                </button>
            </form>
        @endif
    </div>
    <div class="card-body">
        @if($portfolio->images->isEmpty())
            <p class="text-muted text-center">No images uploaded yet.</p>
        @else
            <div class="row" id="allImages">
                @foreach($portfolio->images as $image)
                    <div class="col-md-3 mb-4" data-image-id="{{ $image->id }}">
                        <div class="card {{ $image->is_displayed ? 'border-success' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 200px; object-fit: cover; cursor: pointer;" onclick="selectImage({{ $image->id }}, this)">
                            <div class="card-body text-center">
                                @if($image->is_displayed)
                                    <span class="badge bg-success mb-2">Displayed ({{ $image->display_order }})</span>
                                @else
                                    <span class="badge bg-secondary mb-2">Not Displayed</span>
                                @endif
                                <br>
                                <form action="{{ route('admin.portfolios.images.delete', $image) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this image?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let selectedImageIds = @json($portfolio->displayedImages->pluck('id')->toArray());

document.addEventListener('DOMContentLoaded', function() {
    const selectedContainer = document.getElementById('selectedImages');
    
    if (selectedContainer) {
        new Sortable(selectedContainer, {
            animation: 200,
            ghostClass: 'opacity-50',
            dragClass: 'bg-warning',
            handle: 'div[data-image-id]',
            onEnd: function() {
                updateDisplayOrder();
            }
        });
    }
    
    updateDisplayOrder();
});

function selectImage(imageId, imgElement) {
    const selectedContainer = document.getElementById('selectedImages');
    const existingCard = selectedContainer.querySelector(`div[data-image-id="${imageId}"]`);
    
    if (existingCard) {
        // Deselect - remove from selected area
        existingCard.remove();
        imgElement.parentElement.parentElement.classList.remove('border-success');
        const badge = imgElement.nextElementSibling.querySelector('.badge');
        badge.classList.remove('bg-success');
        badge.classList.add('bg-secondary');
        badge.textContent = 'Not Displayed';
    } else {
        // Select - add to selected area
        const currentCount = selectedContainer.querySelectorAll('div[data-image-id]').length;
        if (currentCount >= 5) {
            alert('You can only select 5 images!');
            return;
        }
        
        // Clone the card
        const card = imgElement.parentElement.parentElement.cloneNode(true);
        const wrapper = document.createElement('div');
        wrapper.setAttribute('data-image-id', imageId);
        wrapper.style.cursor = 'move';
        wrapper.style.flexShrink = '0';
        
        // Set fixed width for card
        card.style.width = '150px';
        card.classList.add('border-success');
        
        // Set image size
        const clonedImg = card.querySelector('img');
        clonedImg.style.width = '150px';
        clonedImg.style.height = '150px';
        clonedImg.removeAttribute('onclick');
        clonedImg.style.cursor = 'move';
        
        wrapper.appendChild(card);
        
        // Update badge
        const badge = card.querySelector('.badge');
        badge.classList.remove('bg-secondary');
        badge.classList.add('bg-success');
        
        // Remove delete button from cloned card
        const deleteBtn = card.querySelector('form');
        if (deleteBtn) deleteBtn.remove();
        
        selectedContainer.appendChild(wrapper);
        
        // Update original card
        imgElement.parentElement.parentElement.classList.add('border-success');
        const origBadge = imgElement.nextElementSibling.querySelector('.badge');
        origBadge.classList.remove('bg-secondary');
        origBadge.classList.add('bg-success');
    }
    
    updateDisplayOrder();
}function selectImage(imageId, imgElement) {
    const selectedContainer = document.getElementById('selectedImages');
    
    // 1. CARA NGITUNG YANG BENER: Cuma itung div yang punya data-image-id
    const currentImages = selectedContainer.querySelectorAll('div[data-image-id]');
    const existingCard = selectedContainer.querySelector(`div[data-image-id="${imageId}"]`);
    
    if (existingCard) {
        // Deselect
        existingCard.remove();
        
        // Balikin tampilan kartu asal
        const originalCard = imgElement.closest('.card');
        originalCard.classList.remove('border-success');
        const badge = originalCard.querySelector('.badge');
        badge.classList.remove('bg-success');
        badge.classList.add('bg-secondary');
        badge.textContent = 'Not Displayed';

        // Kalau kosong banget, balikin tulisan placeholder
        if (selectedContainer.querySelectorAll('div[data-image-id]').length === 0) {
            selectedContainer.innerHTML = '<p class="text-muted text-center w-100 m-0">Click images below to select 5 images, then drag here to reorder</p>';
        }
    } else {
        // Select
        // 2. CEK JUMLAH LAGI SEBELUM NAMBAH
        if (currentImages.length >= 5) {
            alert('Cukup 5 aja jing, jangan maruk!');
            return;
        }
        
        // Hapus tulisan placeholder kalau ini gambar pertama
        if (currentImages.length === 0) {
            selectedContainer.innerHTML = '';
        }
        
        // Clone & Setup Card Baru
        const card = imgElement.closest('.card').cloneNode(true);
        const wrapper = document.createElement('div');
        wrapper.setAttribute('data-image-id', imageId);
        wrapper.style.cssText = 'cursor: move; flex-shrink: 0;';
        
        card.style.width = '150px';
        card.classList.add('border-success');
        
        const clonedImg = card.querySelector('img');
        clonedImg.style.cssText = 'width: 150px; height: 150px; object-fit: cover; cursor: move;';
        clonedImg.removeAttribute('onclick');
        
        const badge = card.querySelector('.badge');
        badge.classList.replace('bg-secondary', 'bg-success');
        
        const deleteBtn = card.querySelector('form');
        if (deleteBtn) deleteBtn.remove();
        
        wrapper.appendChild(card);
        selectedContainer.appendChild(wrapper);
        
        // Update tampilan kartu asal
        imgElement.closest('.card').classList.add('border-success');
        const origBadge = imgElement.closest('.card').querySelector('.badge');
        origBadge.classList.replace('bg-secondary', 'bg-success');
    }
    
    updateDisplayOrder();
}

function updateDisplayOrder() {
    const form = document.getElementById('displayForm');
    const saveBtn = document.getElementById('saveDisplayBtn');
    const selectedContainer = document.getElementById('selectedImages');
    
    // Clear existing hidden inputs
    form.querySelectorAll('input[name^="displayed_images"]').forEach(input => input.remove());
    
    // Get current order from DOM - only direct children with data-image-id
    const orderedElements = Array.from(selectedContainer.children).filter(el => el.hasAttribute('data-image-id'));
    const orderedIds = orderedElements.map(el => el.dataset.imageId).filter(id => id);
    
    // Update badges with order numbers
    orderedElements.forEach((el, index) => {
        const badge = el.querySelector('.badge');
        if (badge) {
            badge.textContent = index + 1;
        }
    });
    
    // Add hidden inputs
    orderedIds.forEach((id, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `displayed_images[${index}]`;
        input.value = id;
        form.appendChild(input);
    });
    
    // Enable/disable save button
    saveBtn.disabled = orderedIds.length !== 5;
    
    if (orderedIds.length !== 5) {
        saveBtn.innerHTML = `<i class="bi bi-exclamation-circle"></i> Select exactly 5 images (${orderedIds.length}/5)`;
        saveBtn.classList.remove('btn-success');
        saveBtn.classList.add('btn-secondary');
    } else {
        saveBtn.innerHTML = '<i class="bi bi-check-circle"></i> Save Display Order';
        saveBtn.classList.remove('btn-secondary');
        saveBtn.classList.add('btn-success');
    }
}
</script>
@endsection
