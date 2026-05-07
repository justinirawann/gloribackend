@if($errors->any())
    <div class="admin-alert admin-alert-error">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-5">
    <div>
        <label class="admin-form-label">Nama Client</label>
        <input type="text" name="name" class="admin-form-input" value="{{ old('name', $testimonial->name ?? '') }}" required>
    </div>

    <div>
        <label class="admin-form-label">Judul Testimoni</label>
        <input type="text" name="title" class="admin-form-input" placeholder="e.g. GREAT COMMUNICATION" value="{{ old('title', $testimonial->title ?? '') }}" required>
        <p class="mt-2 text-sm text-slate-500">Tulis singkat dan impactful, huruf kapital disarankan.</p>
    </div>

    <div>
        <label class="admin-form-label">Industri</label>
        <input type="text" name="industry" class="admin-form-input" placeholder="e.g. Property, F&B, Retail" value="{{ old('industry', $testimonial->industry ?? '') }}" required>
    </div>

    <div>
        <label class="admin-form-label">Deskripsi</label>
        <textarea name="description" class="admin-form-input min-h-[140px]" rows="4" required>{{ old('description', $testimonial->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="admin-form-label">Tanggal Proyek</label>
        <input type="date" name="project_date" class="admin-form-input" value="{{ old('project_date', isset($testimonial) ? \Carbon\Carbon::parse($testimonial->project_date)->format('Y-m-d') : '') }}" required>
    </div>

    <div>
        <label class="admin-form-label">Link ke Portfolio <span class="text-slate-500 font-normal">(opsional)</span></label>
        <select name="portfolio_id" class="admin-form-input">
            <option value="">— Tidak ada —</option>
            @foreach($portfolios as $p)
                <option value="{{ $p->id }}" {{ old('portfolio_id', $testimonial->portfolio_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>
        <p class="mt-2 text-sm text-slate-500">Setiap portfolio hanya bisa dipilih oleh 1 testimoni.</p>
    </div>
</div>
