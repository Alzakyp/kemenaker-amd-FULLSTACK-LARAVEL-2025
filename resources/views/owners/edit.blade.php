@extends('layouts.app')

@section('title', 'Edit Pemilik - PetCare+')

@section('content')
    <h3 class="mb-3">Edit Pemilik</h3>

    <form action="{{ route('owners.update', $owner) }}" method="POST" class="card card-body">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Pemilik</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $owner->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $owner->phone) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" rows="3" class="form-control">{{ old('address', $owner->address) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_phone_verified" id="is_phone_verified" value="1"
                {{ old('is_phone_verified', $owner->is_phone_verified) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_phone_verified">
                Nomor telepon sudah terverifikasi
            </label>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('owners.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
