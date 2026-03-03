@extends('admin.layout')

@section('title', 'Portfolios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Portfolios</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Portfolio
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($portfolios->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-folder" style="font-size: 80px; color: #ddd;"></i>
        <h3 class="mt-3 text-muted">Belum ada portfolio</h3>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Service</th>
                    <th>Nama Portfolio</th>
                    <th>Banner</th>
                    <th>Category</th>
                    <th>Deskripsi</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($portfolios as $portfolio)
                <tr>
                    <td><span class="badge bg-info">{{ $portfolio->service->name }}</span></td>
                    <td><strong>{{ $portfolio->name }}</strong></td>
                    <td>
                        @if($portfolio->banner_image)
                            <img src="{{ asset('storage/' . $portfolio->banner_image) }}" alt="Banner" style="height: 50px; width: auto; border-radius: 4px;">
                        @else
                            <span class="text-muted small">No banner</span>
                        @endif
                    </td>
                    <td><span class="badge bg-secondary">{{ $portfolio->category }}</span></td>
                    <td>{{ Str::limit($portfolio->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.portfolios.images.manage', $portfolio) }}" class="btn btn-sm btn-info" title="Manage Images">
                            <i class="bi bi-images"></i>
                        </a>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $portfolio->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $portfolio->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Portfolio</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Service</label>
                                        <select name="service_id" class="form-control" required>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{ $portfolio->service_id == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Portfolio</label>
                                        <input type="text" name="name" class="form-control" value="{{ $portfolio->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category" class="form-control" required id="editCategory{{ $portfolio->id }}">
                                            <option value="">Pilih Category</option>
                                        </select>
                                        <small class="text-muted">Pilih service dulu untuk melihat categories</small>
                                        <div class="alert alert-warning mt-2 d-none" id="editCategoryWarning{{ $portfolio->id }}">
                                            <i class="bi bi-exclamation-triangle"></i> Service ini belum memiliki kategori. Silakan buat kategori terlebih dahulu.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Banner Image</label>
                                        @if($portfolio->banner_image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $portfolio->banner_image) }}" alt="Current Banner" style="max-width: 100%; height: auto; border-radius: 4px;">
                                            </div>
                                        @endif
                                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah banner</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi (Indonesia)</label>
                                        <textarea name="description" class="form-control" rows="3" required>{{ $portfolio->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi (English)</label>
                                        <textarea name="description_en" class="form-control" rows="3">{{ $portfolio->description_en }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Portfolio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Service</label>
                        <select name="service_id" class="form-control" required id="addServiceSelect">
                            <option value="">Pilih Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Portfolio</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control" required id="addCategorySelect">
                            <option value="">Pilih Category</option>
                        </select>
                        <small class="text-muted">Pilih service dulu untuk melihat categories</small>
                        <div class="alert alert-warning mt-2 d-none" id="addCategoryWarning">
                            <i class="bi bi-exclamation-triangle"></i> Service ini belum memiliki kategori. Silakan buat kategori terlebih dahulu.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Indonesia)</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (English)</label>
                        <textarea name="description_en" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const categories = @json($categories);
const portfolios = @json($portfolios);

// Add Modal - Load categories when service selected
document.getElementById('addServiceSelect').addEventListener('change', function() {
    const serviceId = this.value;
    const categorySelect = document.getElementById('addCategorySelect');
    const warningDiv = document.getElementById('addCategoryWarning');
    categorySelect.innerHTML = '<option value="">Pilih Category</option>';
    
    if (serviceId) {
        const serviceCats = categories.filter(c => c.service_id == serviceId);
        if (serviceCats.length === 0) {
            categorySelect.innerHTML = '<option value="">Service ini belum punya kategori</option>';
            categorySelect.disabled = true;
            warningDiv.classList.remove('d-none');
            alert('⚠️ Service ini belum memiliki kategori!\n\nSilakan buat kategori terlebih dahulu di menu Categories sebelum menambahkan portfolio.');
        } else {
            categorySelect.disabled = false;
            warningDiv.classList.add('d-none');
            serviceCats.forEach(cat => {
                categorySelect.innerHTML += `<option value="${cat.name}">${cat.name}</option>`;
            });
        }
    } else {
        warningDiv.classList.add('d-none');
    }
});

// Edit Modal - Load categories for each portfolio
portfolios.forEach(portfolio => {
    const editServiceSelect = document.querySelector(`#editModal${portfolio.id} select[name="service_id"]`);
    const editCategorySelect = document.getElementById(`editCategory${portfolio.id}`);
    const editWarningDiv = document.getElementById(`editCategoryWarning${portfolio.id}`);
    
    // Load initial categories based on current service
    function loadEditCategories(serviceId, selectedCategory = '') {
        editCategorySelect.innerHTML = '<option value="">Pilih Category</option>';
        
        if (serviceId) {
            const serviceCats = categories.filter(c => c.service_id == serviceId);
            if (serviceCats.length === 0) {
                editCategorySelect.innerHTML = '<option value="">Service ini belum punya kategori</option>';
                editCategorySelect.disabled = true;
                if (editWarningDiv) editWarningDiv.classList.remove('d-none');
            } else {
                editCategorySelect.disabled = false;
                if (editWarningDiv) editWarningDiv.classList.add('d-none');
                serviceCats.forEach(cat => {
                    const selected = cat.name === selectedCategory ? 'selected' : '';
                    editCategorySelect.innerHTML += `<option value="${cat.name}" ${selected}>${cat.name}</option>`;
                });
            }
        }
    }
    
    // Load on page load
    loadEditCategories(portfolio.service_id, portfolio.category);
    
    // Reload when service changes
    editServiceSelect.addEventListener('change', function() {
        const serviceId = this.value;
        loadEditCategories(serviceId);
        
        const serviceCats = categories.filter(c => c.service_id == serviceId);
        if (serviceCats.length === 0) {
            alert('⚠️ Service ini belum memiliki kategori!\n\nSilakan buat kategori terlebih dahulu di menu Categories sebelum mengubah ke service ini.');
        }
    });
});
</script>
@endsection
