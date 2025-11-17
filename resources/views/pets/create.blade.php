@extends('layouts.app')

@section('title', 'Tambah Hewan Baru')
@section('page-title', 'Tambah Hewan Baru')

@section('page-actions')
    <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle"></i> Form Registrasi Hewan
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Info Box -->
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i>
                        <strong>Format Input:</strong> NAMA_HEWAN JENIS USIA BERAT<br>
                        <strong>Contoh:</strong> Milo Kucing 2Th 4.5kg
                    </div>

                    <form action="{{ route('pets.store') }}" method="POST">
                        @csrf

                        <!-- Dropdown Pemilik -->
                        <div class="mb-4">
                            <label for="owner_id" class="form-label">
                                <i class="bi bi-person-check"></i> Pilih Pemilik (Terverifikasi)
                            </label>
                            <select name="owner_id" id="owner_id"
                                class="form-select @error('owner_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pemilik --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}"
                                        {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Data Hewan -->
                        <div class="mb-4">
                            <label for="pet_input" class="form-label">
                                <i class="bi bi-heart"></i> Data Hewan
                            </label>
                            <input type="text" name="pet_input" id="pet_input"
                                class="form-control form-control-lg @error('pet_input') is-invalid @enderror"
                                placeholder="Contoh: Milo Kucing 2Th 4.5kg" value="{{ old('pet_input') }}" required>
                            @error('pet_input')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <strong>Format yang didukung:</strong><br>
                                • Usia: 2tahun, 2thn, 2th, 2TH, 2Tahun<br>
                                • Berat: 4.5kg, 4,5kg, 4.5 KG, 4,5KG
                            </div>
                        </div>

                        <!-- Preview Section (Optional dengan JavaScript) -->
                        <div id="preview-section" class="mb-4" style="display: none;">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="bi bi-eye"></i> Preview Data:</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Nama:</strong>
                                            <div id="preview-name" class="text-primary">-</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Jenis:</strong>
                                            <div id="preview-type" class="text-success">-</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Usia:</strong>
                                            <div id="preview-age" class="text-warning">-</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Berat:</strong>
                                            <div id="preview-weight" class="text-info">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('pets.index') }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Data Hewan
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
        // Preview real-time data parsing
        document.getElementById('pet_input').addEventListener('input', function() {
            const input = this.value.trim();
            const preview = document.getElementById('preview-section');

            if (input.length === 0) {
                preview.style.display = 'none';
                return;
            }

            const parts = input.replace(/\s+/g, ' ').split(' ');

            if (parts.length >= 4) {
                document.getElementById('preview-name').textContent = parts[0].toUpperCase();
                document.getElementById('preview-type').textContent = parts[1].toUpperCase();
                document.getElementById('preview-age').textContent = parts[2];
                document.getElementById('preview-weight').textContent = parts[3];
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
