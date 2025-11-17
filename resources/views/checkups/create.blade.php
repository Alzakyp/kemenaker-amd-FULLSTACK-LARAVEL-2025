@extends('layouts.app')

@section('title', 'Tambah Pemeriksaan - PetCare+')

@section('content')
    <h3 class="mb-3">Tambah Pemeriksaan</h3>

    <form action="{{ route('checkups.store') }}" method="POST" class="card card-body">
        @csrf

        <div class="mb-3">
            <label class="form-label">Hewan</label>
            <select name="pet_id" class="form-select" required>
                <option value="">-- Pilih Hewan --</option>
                @foreach ($pets as $pet)
                    <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                        {{ $pet->name }} ({{ $pet->owner->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Treatment</label>
            <select name="treatment_id" class="form-select" required>
                <option value="">-- Pilih Treatment --</option>
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}" {{ old('treatment_id') == $treatment->id ? 'selected' : '' }}>
                        {{ $treatment->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Pemeriksaan</label>
            <input type="date" name="checkup_date" class="form-control"
                value="{{ old('checkup_date', now()->toDateString()) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Berat Saat Pemeriksaan (kg)</label>
            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}"
                min="0">
            <div class="form-text">
                Opsional. Jika diisi, berat hewan akan ikut diperbarui.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan / Diagnosa</label>
            <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('checkups.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
