@extends('admin.layout')

@section('title', 'Portfolio')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Portfolio Management</h1>
    <button onclick="openModal('addModal')" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Portfolio
    </button>
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
@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
        <div class="flex">
            <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

@if($portfolios->isEmpty())
    <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        <h3 class="mt-4 text-xl text-gray-700 font-semibold">No Portfolio Found</h3>
        <p class="text-gray-600 mt-2">Get started by creating your first portfolio.</p>
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Portfolio Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Banner</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold" width="150">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 hover:bg-gray-50 transition-colors">
                @foreach($portfolios as $portfolio)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm"><span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $portfolio->service->name }}</span></td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $portfolio->name }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($portfolio->banner_image)
                            <img src="{{ asset('storage/' . $portfolio->banner_image) }}" alt="Banner" class="h-12 w-auto rounded-md">
                        @else
                            <span class="text-gray-500 text-xs">No banner</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm"><span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">{{ $portfolio->category }}</span></td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($portfolio->description_en, 50) }}</td>
                    <td class="px-6 py-4 text-sm space-x-2 flex items-center">
                        <a href="{{ route('admin.portfolios.images.manage', $portfolio) }}" class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition-colors" title="Manage Images">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                        <button onclick="openModal('editModal{{ $portfolio->id }}')" class="inline-flex items-center px-3 py-2 bg-amber-500 text-white text-xs rounded hover:bg-amber-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition-colors" onclick="return confirm('Are you sure you want to delete this portfolio?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" id="editModal{{ $portfolio->id }}" role="dialog">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg transform transition-all">
                        <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900">Edit Portfolio</h3>
                            </div>
                            <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service</label>
                                    <select name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ $portfolio->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portfolio Name</label>
                                    <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $portfolio->name }}" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required id="editCategory{{ $portfolio->id }}">
                                        <option value="">Select Category</option>
                                    </select>
                                    <p class="text-gray-600 text-xs mt-1">Select service first to see categories</p>
                                    <div class="hidden p-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm mt-2" id="editCategoryWarning{{ $portfolio->id }}">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        This service has no categories yet. Please create categories first.
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
                                    @if($portfolio->banner_image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $portfolio->banner_image) }}" alt="Current Banner" class="max-w-xs h-auto rounded-lg">
                                        </div>
                                    @endif
                                    <input type="file" name="banner_image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                                    <p class="text-gray-600 text-xs mt-1">Leave empty to keep current banner</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <textarea name="description_en" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required>{{ $portfolio->description_en }}</textarea>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                                <button type="button" onclick="closeModal('editModal{{ $portfolio->id }}')" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Add Modal -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" id="addModal" role="dialog">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg transform transition-all">
        <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Add New Portfolio</h3>
            </div>
            <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service</label>
                    <select name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required id="addServiceSelect">
                        <option value="">Select Service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portfolio Name</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required id="addCategorySelect">
                        <option value="">Select Category</option>
                    </select>
                    <p class="text-gray-600 text-xs mt-1">Select service first to see categories</p>
                    <div class="hidden p-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm mt-2" id="addCategoryWarning">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        This service has no categories yet. Please create categories first.
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
                    <input type="file" name="banner_image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description_en" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('addModal')" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
const categories = @json($categories);
const portfolios = @json($portfolios);

// Modal helper functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking on the overlay
document.addEventListener('click', function(event) {
    if (event.target.id === 'addModal' || event.target.id.startsWith('editModal')) {
        closeModal(event.target.id);
    }
});

// Add Modal - Load categories when service selected
const addServiceSelect = document.getElementById('addServiceSelect');
if (addServiceSelect) {
    addServiceSelect.addEventListener('change', function() {
        const serviceId = this.value;
        const categorySelect = document.getElementById('addCategorySelect');
        const warningDiv = document.getElementById('addCategoryWarning');
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        
        if (serviceId) {
            const serviceCats = categories.filter(c => c.service_id == serviceId);
            if (serviceCats.length === 0) {
                categorySelect.innerHTML = '<option value="">This service has no categories</option>';
                categorySelect.disabled = true;
                warningDiv.classList.remove('hidden');
                alert('⚠️ This service has no categories!\n\nPlease create categories first in the Categories menu before adding a portfolio.');
            } else {
                categorySelect.disabled = false;
                warningDiv.classList.add('hidden');
                serviceCats.forEach(cat => {
                    categorySelect.innerHTML += `<option value="${cat.name}">${cat.name}</option>`;
                });
            }
        } else {
            warningDiv.classList.add('hidden');
        }
    });
}

// Edit Modal - Load categories for each portfolio
portfolios.forEach(portfolio => {
    const editModal = document.getElementById(`editModal${portfolio.id}`);
    if (!editModal) return;
    
    const editServiceSelect = editModal.querySelector('select[name="service_id"]');
    const editCategorySelect = document.getElementById(`editCategory${portfolio.id}`);
    const editWarningDiv = document.getElementById(`editCategoryWarning${portfolio.id}`);
    
    function loadEditCategories(serviceId, selectedCategory = '') {
        editCategorySelect.innerHTML = '<option value="">Select Category</option>';
        
        if (serviceId) {
            const serviceCats = categories.filter(c => c.service_id == serviceId);
            if (serviceCats.length === 0) {
                editCategorySelect.innerHTML = '<option value="">This service has no categories</option>';
                editCategorySelect.disabled = true;
                if (editWarningDiv) editWarningDiv.classList.remove('hidden');
            } else {
                editCategorySelect.disabled = false;
                if (editWarningDiv) editWarningDiv.classList.add('hidden');
                serviceCats.forEach(cat => {
                    const selected = cat.name === selectedCategory ? 'selected' : '';
                    editCategorySelect.innerHTML += `<option value="${cat.name}" ${selected}>${cat.name}</option>`;
                });
            }
        }
    }
    
    loadEditCategories(portfolio.service_id, portfolio.category);
    
    editServiceSelect.addEventListener('change', function() {
        const serviceId = this.value;
        loadEditCategories(serviceId);
        
        const serviceCats = categories.filter(c => c.service_id == serviceId);
        if (serviceCats.length === 0) {
            alert('⚠️ This service has no categories!\n\nPlease create categories first in the Categories menu before changing to this service.');
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});
</script>
@endsection
