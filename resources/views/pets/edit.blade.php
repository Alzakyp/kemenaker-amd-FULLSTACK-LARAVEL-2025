@extends('layouts.app')

@section('title', 'Edit Hewan - PetCare+')

@section('content')
    <h3 class="mb-3">Edit Hewan</h3>

    <form action="{{ route('pets.update', $pet) }}" method="POST" class="card card-body">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Pemilik Hewan</label>
            <select name="owner_id" class="form-select" required>
                @foreach ($owners as $owner)
                    <option value="{{ $owner->id }}"
                        {{ old('owner_id', $pet->owner_id) == $owner->id ? 'selected' : '' }}>
                        {{ $owner->name }} ({{ $owner->phone }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kode Hewan</label>
            <input type="text" class="form-control" value="{{ $pet->code }}" disabled>
            <div class="form-text">
                Kode hewan dibuat otomatis saat pendaftaran dan tidak dapat diubah.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Hewan</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pet->name) }}" required>
            <div class="form-text">
                Akan disimpan dalam huruf besar (UPPERCASE).
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Hewan</label>
            <input type="text" name="type" class="form-control" value="{{ old('type', $pet->type) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Usia (tahun)</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $pet->age) }}" min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Berat (kg)</label>
            <input type="number" step="0.01" name="weight" class="form-control"
                value="{{ old('weight', $pet->weight) }}" min="0">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
