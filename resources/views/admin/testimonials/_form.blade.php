@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Client</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Judul Testimoni</label>
    <input type="text" name="title" class="form-control" placeholder="e.g. GREAT COMMUNICATION" value="{{ old('title', $testimonial->title ?? '') }}" required>
    <div class="form-text">Tulis singkat dan impactful, huruf kapital disarankan.</div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Industri</label>
    <input type="text" name="industry" class="form-control" placeholder="e.g. Property, F&B, Retail" value="{{ old('industry', $testimonial->industry ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Rating</label>
    <input type="number" name="rating" class="form-control" min="1" max="5" step="0.5" value="{{ old('rating', $testimonial->rating ?? 5) }}" required>
    <div class="form-text">Bisa desimal, contoh: 4.5, 3.5</div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Deskripsi</label>
    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $testimonial->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Tanggal Proyek</label>
    <input type="date" name="project_date" class="form-control" value="{{ old('project_date', isset($testimonial) ? \Carbon\Carbon::parse($testimonial->project_date)->format('Y-m-d') : '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Link ke Portfolio <span class="text-muted fw-normal">(opsional)</span></label>
    <select name="portfolio_id" class="form-select">
        <option value="">— Tidak ada —</option>
        @foreach($portfolios as $p)
            <option value="{{ $p->id }}" {{ old('portfolio_id', $testimonial->portfolio_id ?? '') == $p->id ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
        @endforeach
    </select>
    <div class="form-text">Setiap portfolio hanya bisa dipilih oleh 1 testimoni.</div>
</div>
