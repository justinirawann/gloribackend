@extends('admin.layout')

@section('title', 'Manage Portfolio Images')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Portfolio
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-gray-800">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $portfolio->name }} - Images</h2>
    <p class="text-gray-600 text-sm">Service: <span class="font-semibold">{{ $portfolio->service->name }}</span> | Category: <span class="font-semibold">{{ $portfolio->category }}</span></p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
        <div class="flex">
            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- Upload Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            Upload Images
        </h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.portfolios.images.upload', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <input type="file" name="images[]" class="block w-full px-4 py-2 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" accept="image/*" multiple required>
                <p class="text-gray-600 text-sm mt-2">Max 10MB per image. You can select multiple images.</p>
            </div>
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload Images
            </button>
        </form>
    </div>
</div>

<!-- Display Selection Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-amber-50">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Select 5 Images to Display (Drag to Reorder)
        </h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.portfolios.images.display', $portfolio) }}" method="POST" id="displayForm">
            @csrf
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-800 text-sm">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                    </svg>
                    <span>Select exactly 5 images to display on the frontend. Drag to change order (1-5).</span>
                </div>
            </div>
            
            <div id="selectedImages" class="flex flex-wrap gap-3 mb-6 p-4 min-h-[200px] border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 overflow-x-auto">
                @if($portfolio->displayedImages->isEmpty())
                    <p class="text-gray-500 text-center w-full my-auto">Click images below to select 5 images, then drag here to reorder</p>
                @else
                    @foreach($portfolio->displayedImages as $img)
                        <div data-image-id="{{ $img->id }}" class="flex-shrink-0 cursor-move">
                            <div class="border-2 border-green-500 rounded-lg p-2 bg-white">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-[150px] h-[150px] object-cover rounded" alt="Portfolio image">
                                <div class="text-center mt-2">
                                    <span class="inline-block px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded">{{ $img->display_order }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed" id="saveDisplayBtn" disabled>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Display Order
            </button>
        </form>
    </div>
</div>

<!-- All Images Gallery -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            All Images ({{ $portfolio->images->count() }})
        </h3>
        @if($portfolio->images->count() > 0)
            <form action="{{ route('admin.portfolios.images.deleteAll', $portfolio) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors font-semibold" onclick="return confirm('Delete ALL images from this portfolio? This cannot be undone!')">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete All
                </button>
            </form>
        @endif
    </div>
    <div class="p-6">
        @if($portfolio->images->isEmpty())
            <p class="text-gray-500 text-center py-8">No images uploaded yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="allImages">
                @foreach($portfolio->images as $image)
                    <div class="bg-white border rounded-lg overflow-hidden {{ $image->is_displayed ? 'border-green-500 border-2' : 'border-gray-200' }}" data-image-id="{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-[200px] object-cover cursor-pointer hover:opacity-75 transition-opacity" onclick="selectImage({{ $image->id }}, this)" alt="Portfolio image">
                        <div class="p-4 text-center">
                            @if($image->is_displayed)
                                <span class="inline-block px-3 py-1 bg-green-500 text-white text-sm font-semibold rounded-full mb-3">Displayed ({{ $image->display_order }})</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-500 text-white text-sm font-semibold rounded-full mb-3">Not Displayed</span>
                            @endif
                            <div>
                                <form action="{{ route('admin.portfolios.images.delete', $image) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors font-semibold" onclick="return confirm('Delete this image?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
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
    const currentImages = selectedContainer.querySelectorAll('div[data-image-id]');
    const existingCard = selectedContainer.querySelector(`div[data-image-id="${imageId}"]`);
    
    if (existingCard) {
        // Deselect - remove from selected area
        existingCard.remove();
        const originalCard = imgElement.closest('.border');
        originalCard.classList.remove('border-2', 'border-green-500');
        originalCard.classList.add('border', 'border-gray-200');
        const badge = originalCard.querySelector('[class*="bg-green"]');
        if (badge) {
            badge.classList.remove('bg-green-500');
            badge.classList.add('bg-gray-500');
            badge.textContent = 'Not Displayed';
        }

        if (selectedContainer.querySelectorAll('div[data-image-id]').length === 0) {
            selectedContainer.innerHTML = '<p class="text-gray-500 text-center w-full my-auto">Click images below to select 5 images, then drag here to reorder</p>';
        }
    } else {
        // Select - add to selected area
        if (currentImages.length >= 5) {
            alert('You can only select 5 images!');
            return;
        }
        
        if (currentImages.length === 0) {
            selectedContainer.innerHTML = '';
        }
        
        // Clone the card
        const card = imgElement.closest('.border').cloneNode(true);
        const wrapper = document.createElement('div');
        wrapper.setAttribute('data-image-id', imageId);
        wrapper.style.cssText = 'cursor: move; flex-shrink: 0;';
        
        card.className = 'border-2 border-green-500 rounded-lg p-2 bg-white';
        
        const clonedImg = card.querySelector('img');
        clonedImg.className = 'w-[150px] h-[150px] object-cover rounded';
        clonedImg.removeAttribute('onclick');
        clonedImg.style.cursor = 'move';
        
        const badgeContainer = card.querySelector('.text-center');
        if (badgeContainer) {
            const badge = badgeContainer.querySelector('[class*="bg-"]');
            if (badge) {
                badge.classList.remove('bg-gray-500', 'bg-green-500');
                badge.classList.add('bg-green-500');
            }
        }
        
        const deleteBtn = card.querySelector('form');
        if (deleteBtn) deleteBtn.remove();
        
        wrapper.appendChild(card);
        selectedContainer.appendChild(wrapper);
        
        // Update original card
        imgElement.closest('.border').classList.remove('border', 'border-gray-200');
        imgElement.closest('.border').classList.add('border-2', 'border-green-500');
        const origBadge = imgElement.closest('.border').querySelector('[class*="bg-"]');
        if (origBadge) {
            origBadge.classList.remove('bg-gray-500');
            origBadge.classList.add('bg-green-500');
        }
    }
    
    updateDisplayOrder();
}

function updateDisplayOrder() {
    const form = document.getElementById('displayForm');
    const saveBtn = document.getElementById('saveDisplayBtn');
    const selectedContainer = document.getElementById('selectedImages');
    
    // Clear existing hidden inputs
    form.querySelectorAll('input[name^="displayed_images"]').forEach(input => input.remove());
    
    // Get current order from DOM
    const orderedElements = Array.from(selectedContainer.children).filter(el => el.hasAttribute('data-image-id'));
    const orderedIds = orderedElements.map(el => el.dataset.imageId).filter(id => id);
    
    // Update badges with order numbers
    orderedElements.forEach((el, index) => {
        const badge = el.querySelector('[class*="bg-green"]');
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
        saveBtn.innerHTML = `<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Select exactly 5 images (${orderedIds.length}/5)`;
        saveBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        saveBtn.classList.add('bg-gray-400');
    } else {
        saveBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Save Display Order';
        saveBtn.classList.remove('bg-gray-400');
        saveBtn.classList.add('bg-green-600', 'hover:bg-green-700');
    }
}
</script>
@endsection
