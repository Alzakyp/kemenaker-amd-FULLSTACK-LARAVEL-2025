@extends('layouts.app')

@section('title', 'Edit Pemeriksaan - PetCare+')

@section('content')
    <h3 class="mb-3">Edit Pemeriksaan</h3>

    <form action="{{ route('checkups.update', $checkup) }}" method="POST" class="card card-body">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Hewan</label>
            <select name="pet_id" class="form-select" required>
                @foreach ($pets as $pet)
                    <option value="{{ $pet->id }}" {{ old('pet_id', $checkup->pet_id) == $pet->id ? 'selected' : '' }}>
                        {{ $pet->name }} ({{ $pet->owner->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Treatment</label>
            <select name="treatment_id" class="form-select" required>
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}"
                        {{ old('treatment_id', $checkup->treatment_id) == $treatment->id ? 'selected' : '' }}>
                        {{ $treatment->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Pemeriksaan</label>
            <input type="date" name="checkup_date" class="form-control"
                value="{{ old('checkup_date', $checkup->checkup_date->toDateString()) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Berat Saat Pemeriksaan (kg)</label>
            <input type="number" step="0.01" name="weight" class="form-control"
                value="{{ old('weight', $checkup->weight_at_checkup) }}" min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan / Diagnosa</label>
            <textarea name="notes" rows="3" class="form-control">{{ old('notes', $checkup->notes) }}</textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('checkups.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
