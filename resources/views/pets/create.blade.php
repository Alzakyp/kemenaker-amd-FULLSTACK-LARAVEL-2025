@extends('layouts.app')

@section('title', 'Tambah Hewan Baru - VetClinic Pro')
@section('page-title', 'Tambah Hewan Baru')
@section('page-description', 'Daftarkan hewan baru dengan format yang mudah')

@section('page-actions')
    <a href="{{ route('pets.index') }}" class="btn btn-outline-light btn-modern">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card card-modern">
            <div class="card-header-modern">
                <i class="bi bi-plus-circle-fill me-2"></i>Form Registrasi Hewan
            </div>
            <div class="card-body p-4">
                <!-- Info Box -->
                <div class="alert alert-info alert-modern mb-4">
                    <div class="d-flex">
                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-info-circle-fill text-info"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading mb-2">Format Input Hewan</h6>
                            <p class="mb-2"><strong>Format:</strong> NAMA_HEWAN JENIS USIA BERAT</p>
                            <p class="mb-0"><strong>Contoh:</strong> <code>Milo Kucing 2Th 4.5kg</code></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('pets.store') }}" method="POST">
                    @csrf

                    <!-- Dropdown Pemilik -->
                    <div class="mb-4">
                        <label for="owner_id" class="form-label form-label-modern">
                            <i class="bi bi-person-check-fill me-2"></i>Pilih Pemilik (Terverifikasi)
                        </label>
                        <select name="owner_id" id="owner_id"
                                class="form-select form-control-modern @error('owner_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                    <i class="bi bi-person-fill"></i> {{ $owner->name }} ({{ $owner->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($owners->count() == 0)
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum ada pemilik yang terverifikasi. <a href="{{ route('owners.create') }}">Tambah pemilik baru</a>
                            </div>
                        @endif
                    </div>

                    <!-- Input Data Hewan -->
                    <div class="mb-4">
                        <label for="pet_input" class="form-label form-label-modern">
                            <i class="bi bi-heart-fill me-2"></i>Data Hewan
                        </label>
                        <input type="text"
                               name="pet_input"
                               id="pet_input"
                               class="form-control form-control-modern @error('pet_input') is-invalid @enderror"
                               placeholder="Contoh: Milo Kucing 2Th 4.5kg"
                               value="{{ old('pet_input') }}"
                               required>
                        @error('pet_input')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Format Usia:</strong> 2tahun, 2thn, 2th, 2TH, 2Tahun
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Format Berat:</strong> 4.5kg, 4,5kg, 4.5 KG, 4,5KG
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div id="preview-section" class="mb-4" style="display: none;">
                        <div class="card" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border: 2px dashed #cbd5e1;">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-eye-fill me-2"></i>Preview Data Hewan
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2">
                                                <i class="bi bi-card-text text-primary fs-4"></i>
                                            </div>
                                            <strong class="text-primary">Nama</strong>
                                            <div id="preview-name" class="fw-bold mt-1">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-2">
                                                <i class="bi bi-tag text-success fs-4"></i>
                                            </div>
                                            <strong class="text-success">Jenis</strong>
                                            <div id="preview-type" class="fw-bold mt-1">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-2">
                                                <i class="bi bi-calendar3 text-warning fs-4"></i>
                                            </div>
                                            <strong class="text-warning">Usia</strong>
                                            <div id="preview-age" class="fw-bold mt-1">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="bg-info bg-opacity-10 rounded-3 p-3 mb-2">
                                                <i class="bi bi-speedometer text-info fs-4"></i>
                                            </div>
                                            <strong class="text-info">Berat</strong>
                                            <div id="preview-weight" class="fw-bold mt-1">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary btn-modern">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary-modern btn-modern">
                            <i class="bi bi-save-fill me-2"></i>Simpan Data Hewan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Preview real-time data parsing dengan animasi
document.getElementById('pet_input').addEventListener('input', function() {
    const input = this.value.trim();
    const preview = document.getElementById('preview-section');

    if (input.length === 0) {
        preview.style.display = 'none';
        return;
    }

    const parts = input.replace(/\s+/g, ' ').split(' ');

    if (parts.length >= 4) {
        // Show preview with animation
        if (preview.style.display === 'none') {
            preview.style.display = 'block';
            preview.style.opacity = '0';
            setTimeout(() => {
                preview.style.transition = 'opacity 0.3s ease';
                preview.style.opacity = '1';
            }, 10);
        }

        // Update preview values with animation
        updatePreviewValue('preview-name', parts[0].toUpperCase());
        updatePreviewValue('preview-type', parts[1].toUpperCase());
        updatePreviewValue('preview-age', parts[2]);
        updatePreviewValue('preview-weight', parts[3]);
    } else {
        preview.style.opacity = '0';
        setTimeout(() => {
            preview.style.display = 'none';
        }, 300);
    }
});

function updatePreviewValue(elementId, value) {
    const element = document.getElementById(elementId);
    element.style.transform = 'scale(0.8)';
    element.style.transition = 'transform 0.2s ease';

    setTimeout(() => {
        element.textContent = value;
        element.style.transform = 'scale(1)';
    }, 100);
}

// Form validation enhancement
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading me-2"></span>Menyimpan...';

    // Re-enable if form validation fails
    setTimeout(() => {
        if (this.checkValidity() === false) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }, 100);
});
</script>
@endsection
