@extends('admin.layout')

@section('title', 'Website Content')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Website Content Management</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola konten situs seperti landing image, about image, kontak, dan logo klien.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <button type="button" data-tab-target="#landing" class="content-tab-btn px-4 py-3 text-left text-sm font-medium text-slate-900 bg-slate-100">Landing Images</button>
        <button type="button" data-tab-target="#about" class="content-tab-btn px-4 py-3 text-left text-sm font-medium text-slate-600 hover:bg-slate-50">About Images</button>
        <button type="button" data-tab-target="#contact" class="content-tab-btn px-4 py-3 text-left text-sm font-medium text-slate-600 hover:bg-slate-50">Contact Info</button>
        <button type="button" data-tab-target="#logos" class="content-tab-btn px-4 py-3 text-left text-sm font-medium text-slate-600 hover:bg-slate-50">Client Logos</button>
    </div>

    <div class="space-y-6">
        <div id="landing" data-tab-pane class="block">
            <div class="admin-card">
                <div class="admin-card-body space-y-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Landing Images</h2>
                            <p class="text-sm text-slate-500">Tambahkan atau sunting gambar landing page.</p>
                        </div>
                        <button type="button" data-modal-open="#addLandingModal" class="admin-btn-primary inline-flex items-center justify-center gap-2">
                            <span>Tambah Image</span>
                        </button>
                    </div>

                    @if($landingImages->isEmpty())
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center">
                            <div class="text-slate-400 text-6xl">🖼️</div>
                            <h3 class="mt-4 text-xl font-semibold text-slate-900">Belum ada landing image</h3>
                            <p class="mt-2 text-sm text-slate-500">Tambahkan gambar pertama agar tampilan landing page terlihat lebih menarik.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                            @foreach($landingImages as $image)
                            <div class="admin-card overflow-hidden">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Landing image {{ $image->id }}" class="h-48 w-full object-cover" />
                                <div class="p-4 space-y-3">
                                    <div class="text-sm text-slate-500">Order: {{ $image->order }}</div>
                                    <div class="flex flex-col gap-2 sm:flex-row">
                                        <button type="button" data-modal-open="#editLandingModal{{ $image->id }}" class="admin-btn-warning flex-1">Edit</button>
                                        <form action="{{ route('admin.website-content.landing-image.destroy', $image) }}" method="POST" class="flex-1" onsubmit="addTabToAction(this, 'landing')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="admin-btn-danger w-full" onclick="return confirm('Yakin hapus gambar ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="about" data-tab-pane class="hidden">
            <div class="admin-card">
                <div class="admin-card-body space-y-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">About Us Images</h2>
                        <p class="text-sm text-slate-500">Perbarui gambar pada bagian hero dan statistik.</p>
                    </div>

                    <form action="{{ route('admin.website-content.about-images.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="active_tab" value="about">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div class="admin-card">
                                <div class="admin-card-header">Top Image (Hero Section)</div>
                                <div class="admin-card-body space-y-4">
                                    <div id="topImagePreview">
                                        @if($aboutImageTop)
                                            <img src="{{ asset('storage/' . $aboutImageTop->image_path) }}" alt="Top about image" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
                                        @else
                                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                                                <span class="text-4xl">🖼️</span>
                                                <p class="mt-4">Belum ada gambar</p>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="top_image" id="topImageInput" class="admin-form-input" accept="image/*" onchange="previewImage(this, 'topImagePreview')">
                                </div>
                            </div>

                            <div class="admin-card">
                                <div class="admin-card-header">Bottom Image (Stats Section)</div>
                                <div class="admin-card-body space-y-4">
                                    <div id="bottomImagePreview">
                                        @if($aboutImageBottom)
                                            <img src="{{ asset('storage/' . $aboutImageBottom->image_path) }}" alt="Bottom about image" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
                                        @else
                                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                                                <span class="text-4xl">🖼️</span>
                                                <p class="mt-4">Belum ada gambar</p>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="bottom_image" id="bottomImageInput" class="admin-form-input" accept="image/*" onchange="previewImage(this, 'bottomImagePreview')">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="admin-btn-success">Update About Images</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="contact" data-tab-pane class="hidden">
            <div class="admin-card">
                <div class="admin-card-body space-y-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">Contact Information</h2>
                        <p class="text-sm text-slate-500">Perbarui informasi kontak yang muncul di halaman website.</p>
                    </div>

                    <form action="{{ route('admin.website-content.contact-info.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="active_tab" value="contact">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div class="space-y-4">
                                <label class="admin-form-label">Email</label>
                                <input type="email" name="email" class="admin-form-input" value="{{ $contactInfo->email ?? '' }}" required>

                                <label class="admin-form-label">Email Display Name</label>
                                <input type="text" name="email_name" class="admin-form-input" value="{{ $contactInfo->email_name ?? '' }}" placeholder="e.g., Email Us">

                                <label class="admin-form-label">Phone</label>
                                <input type="text" name="phone" class="admin-form-input" value="{{ $contactInfo->phone ?? '' }}" required>

                                <label class="admin-form-label">Phone Display Name</label>
                                <input type="text" name="phone_name" class="admin-form-input" value="{{ $contactInfo->phone_name ?? '' }}" placeholder="e.g., Call Us">
                            </div>

                            <div class="space-y-4">
                                <label class="admin-form-label">Instagram</label>
                                <input type="text" name="instagram" class="admin-form-input" value="{{ $contactInfo->instagram ?? '' }}" placeholder="Instagram URL">

                                <label class="admin-form-label">Instagram Display Name</label>
                                <input type="text" name="instagram_name" class="admin-form-input" value="{{ $contactInfo->instagram_name ?? '' }}" placeholder="e.g., Follow Us">

                                <label class="admin-form-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="admin-form-input" value="{{ $contactInfo->whatsapp ?? '' }}" placeholder="WhatsApp number">

                                <label class="admin-form-label">WhatsApp Display Name</label>
                                <input type="text" name="whatsapp_name" class="admin-form-input" value="{{ $contactInfo->whatsapp_name ?? '' }}" placeholder="e.g., Chat with Us">
                            </div>
                        </div>

                        <div>
                            <label class="admin-form-label">Address</label>
                            <textarea name="address" class="admin-form-input min-h-[140px]" rows="3" required>{{ $contactInfo->address ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="admin-btn-success">Update Contact Info</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="logos" data-tab-pane class="hidden">
            <div class="admin-card">
                <div class="admin-card-body space-y-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Client Logos</h2>
                            <p class="text-sm text-slate-500">Kelola logo klien yang tampil di website.</p>
                        </div>
                        <button type="button" data-modal-open="#addLogoModal" class="admin-btn-primary inline-flex items-center justify-center gap-2">
                            <span>Add Logo</span>
                        </button>
                    </div>

                    @if($clientLogos->isEmpty())
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center">
                            <div class="text-slate-400 text-6xl">🏢</div>
                            <h3 class="mt-4 text-xl font-semibold text-slate-900">No client logos yet</h3>
                            <p class="mt-2 text-sm text-slate-500">Tambahkan logo klien untuk memperkuat kepercayaan brand.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                            @foreach($clientLogos as $logo)
                            <div class="admin-card overflow-hidden">
                                <img src="{{ asset('storage/' . $logo->image_path) }}" alt="Client logo {{ $logo->id }}" class="h-32 w-full object-contain p-4 bg-slate-50" />
                                <div class="p-4">
                                    <form action="{{ route('admin.website-content.client-logo.destroy', $logo) }}" method="POST" onsubmit="addTabToAction(this, 'logos')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-danger w-full" onclick="return confirm('Yakin hapus logo ini?')">Hapus Logo</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.website-content.modals')
@endsection

@section('scripts')
<script>
// Tab Management
function initTabs() {
    const tabButtons = document.querySelectorAll('.content-tab-btn');
    const tabPanes = document.querySelectorAll('[data-tab-pane]');
    
    // Check for active tab from URL or session
    const urlParams = new URLSearchParams(window.location.search);
    let activeTab = urlParams.get('tab');
    
    // If no tab in URL, check localStorage for last active tab
    if (!activeTab) {
        activeTab = localStorage.getItem('websiteContentActiveTab') || 'landing';
    }
    
    // Save current tab to localStorage
    localStorage.setItem('websiteContentActiveTab', activeTab);
    
    // Set active tab
    setActiveTab(activeTab);
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-tab-target').substring(1);
            setActiveTab(target);
            
            // Save to localStorage
            localStorage.setItem('websiteContentActiveTab', target);
            
            // Update URL without page reload
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('tab', target);
            window.history.replaceState({}, '', newUrl);
        });
    });
}

function setActiveTab(tabId) {
    console.log('Setting active tab to:', tabId);
    
    const tabButtons = document.querySelectorAll('.content-tab-btn');
    const tabPanes = document.querySelectorAll('[data-tab-pane]');
    
    // Reset all tabs
    tabButtons.forEach(btn => {
        btn.classList.remove('bg-slate-100', 'text-slate-900');
        btn.classList.add('text-slate-600', 'hover:bg-slate-50');
    });
    
    tabPanes.forEach(pane => {
        pane.classList.add('hidden');
        pane.classList.remove('block');
    });
    
    // Activate selected tab
    const activeButton = document.querySelector(`[data-tab-target="#${tabId}"]`);
    const activePane = document.getElementById(tabId);
    
    if (activeButton && activePane) {
        activeButton.classList.add('bg-slate-100', 'text-slate-900');
        activeButton.classList.remove('text-slate-600', 'hover:bg-slate-50');
        
        activePane.classList.remove('hidden');
        activePane.classList.add('block');
        
        console.log('Tab activated successfully:', tabId);
    } else {
        console.error('Tab not found:', tabId);
    }
}

// Image Preview Function
function previewImage(input, previewContainerId) {
    const previewContainer = document.getElementById(previewContainerId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Modal Image Preview Function
function previewModalImage(input, previewContainerId) {
    const previewContainer = document.getElementById(previewContainerId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
            `;
            previewContainer.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
}

// Modal Management
function initModals() {
    // Open modal
    document.querySelectorAll('[data-modal-open]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modalId = trigger.getAttribute('data-modal-open');
            const modal = document.querySelector(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modal
    document.querySelectorAll('[data-modal-close]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modal = trigger.closest('.admin-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });
    
    // Close modal on overlay click
    document.querySelectorAll('.admin-modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });
}

// Add tab parameter to form action
function addTabToAction(form, tabName) {
    // Save to localStorage
    localStorage.setItem('websiteContentActiveTab', tabName);
    
    const action = form.getAttribute('action');
    const separator = action.includes('?') ? '&' : '?';
    form.setAttribute('action', action + separator + 'tab=' + tabName);
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing website content management...');
    
    initTabs();
    initModals();
    
    // Handle form submissions to maintain active tab
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Get current active tab
            const currentTab = document.querySelector('.content-tab-btn.bg-slate-100');
            let currentTabId = 'landing';
            
            if (currentTab) {
                currentTabId = currentTab.getAttribute('data-tab-target').substring(1);
            }
            
            console.log('Form submitting, current tab:', currentTabId);
            
            // Save to localStorage before form submission
            localStorage.setItem('websiteContentActiveTab', currentTabId);
            
            // Add to hidden input if exists
            const activeTabInput = form.querySelector('input[name="active_tab"]');
            if (activeTabInput) {
                activeTabInput.value = currentTabId;
            }
            
            // Add tab parameter to action URL
            const action = form.getAttribute('action');
            const separator = action.includes('?') ? '&' : '?';
            const newAction = action + separator + 'tab=' + currentTabId;
            form.setAttribute('action', newAction);
            
            console.log('Form action updated to:', newAction);
        });
    });
});

// Handle page load with tab parameter
window.addEventListener('load', function() {
    console.log('Page loaded, checking for active tab...');
    
    const urlParams = new URLSearchParams(window.location.search);
    let tabParam = urlParams.get('tab');
    
    console.log('Tab from URL:', tabParam);
    
    // If no tab in URL, get from localStorage
    if (!tabParam) {
        tabParam = localStorage.getItem('websiteContentActiveTab') || 'landing';
        console.log('Tab from localStorage:', tabParam);
    }
    
    // Set active tab and save to localStorage
    setActiveTab(tabParam);
    localStorage.setItem('websiteContentActiveTab', tabParam);
    
    // Update URL to reflect current tab without page reload
    const newUrl = new URL(window.location);
    newUrl.searchParams.set('tab', tabParam);
    window.history.replaceState({}, '', newUrl);
    
    console.log('Final active tab set to:', tabParam);
});

// Also handle when page is fully loaded (including all resources)
window.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure everything is loaded
    setTimeout(() => {
        const urlParams = new URLSearchParams(window.location.search);
        let tabParam = urlParams.get('tab');
        
        if (!tabParam) {
            tabParam = localStorage.getItem('websiteContentActiveTab') || 'landing';
        }
        
        setActiveTab(tabParam);
        localStorage.setItem('websiteContentActiveTab', tabParam);
    }, 100);
});
</script>