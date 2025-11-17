@extends('layouts.app')

@section('title', 'Edit Treatment - PetCare+')

@section('content')
    <h3 class="mb-3">Edit Treatment</h3>

    <form action="{{ route('treatments.update', $treatment) }}" method="POST" class="card card-body">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Treatment</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $treatment->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $treatment->price) }}"
                min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $treatment->description) }}</textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('treatments.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
