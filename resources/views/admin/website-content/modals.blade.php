<div class="fixed inset-0 z-50 admin-modal hidden items-center justify-center bg-slate-900/60 p-4" id="addLandingModal">
    <div class="w-full max-w-2xl rounded-[26px] bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h5 class="text-lg font-semibold text-slate-900">Tambah Landing Image</h5>
            <button type="button" data-modal-close class="text-slate-500 hover:text-slate-900 text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.website-content.landing-image.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
            @csrf
            <input type="hidden" name="active_tab" value="landing">
            <div class="space-y-3">
                <label class="admin-form-label">Image</label>
                <div id="addLandingImagePreview" class="mb-3 hidden">
                    <img src="" alt="Preview" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
                </div>
                <input type="file" name="image" id="addLandingImageInput" class="admin-form-input" accept="image/*" required onchange="previewModalImage(this, 'addLandingImagePreview')">
            </div>
            <div class="space-y-3">
                <label class="admin-form-label">Order</label>
                <input type="number" name="order" class="admin-form-input" value="0">
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="admin-btn-secondary">Batal</button>
                <button type="submit" class="admin-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@foreach($landingImages as $image)
<div class="fixed inset-0 z-50 admin-modal hidden items-center justify-center bg-slate-900/60 p-4" id="editLandingModal{{ $image->id }}">
    <div class="w-full max-w-2xl rounded-[26px] bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h5 class="text-lg font-semibold text-slate-900">Edit Landing Image</h5>
            <button type="button" data-modal-close class="text-slate-500 hover:text-slate-900 text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.website-content.landing-image.update', $image) }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
            @csrf @method('PUT')
            <input type="hidden" name="active_tab" value="landing">
            <div class="space-y-3">
                <label class="admin-form-label">Image Baru (opsional)</label>
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Current Image" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
                </div>
                <div id="editLandingImagePreview{{ $image->id }}" class="mb-3 hidden">
                    <img src="" alt="Preview" class="w-full rounded-2xl object-cover" style="max-height: 200px;" />
                </div>
                <input type="file" name="image" class="admin-form-input" accept="image/*" onchange="previewModalImage(this, 'editLandingImagePreview{{ $image->id }}')">
            </div>
            <div class="space-y-3">
                <label class="admin-form-label">Order</label>
                <input type="number" name="order" class="admin-form-input" value="{{ $image->order }}">
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="admin-btn-secondary">Batal</button>
                <button type="submit" class="admin-btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="fixed inset-0 z-50 admin-modal hidden items-center justify-center bg-slate-900/60 p-4" id="addLogoModal">
    <div class="w-full max-w-2xl rounded-[26px] bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
            <h5 class="text-lg font-semibold text-slate-900">Add Client Logo</h5>
            <button type="button" data-modal-close class="text-slate-500 hover:text-slate-900 text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.website-content.client-logo.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 px-6 py-6">
            @csrf
            <input type="hidden" name="active_tab" value="logos">
            <div class="space-y-3">
                <label class="admin-form-label">Logo Image</label>
                <div id="addLogoImagePreview" class="mb-3 hidden">
                    <img src="" alt="Preview" class="w-full rounded-2xl object-contain bg-slate-50 p-4" style="max-height: 200px;" />
                </div>
                <input type="file" name="image" class="admin-form-input" accept="image/*" required onchange="previewModalImage(this, 'addLogoImagePreview')">
                <p class="text-sm text-slate-500">Recommended: PNG with transparent background</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="admin-btn-secondary">Cancel</button>
                <button type="submit" class="admin-btn-primary">Add Logo</button>
            </div>
        </form>
    </div>
</div>