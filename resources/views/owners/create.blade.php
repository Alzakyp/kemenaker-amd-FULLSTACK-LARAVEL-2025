@extends('layouts.app')

@section('title', 'Tambah Pemilik - PetCare+')

@section('content')
    <h3 class="mb-3">Tambah Pemilik</h3>

    <form action="{{ route('owners.store') }}" method="POST" class="card card-body">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Pemilik</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            <div class="form-text">
                Gunakan format yang konsisten, misal: 08123456789.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" rows="3" class="form-control">{{ old('address') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_phone_verified" id="is_phone_verified" value="1"
                {{ old('is_phone_verified') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_phone_verified">
                Nomor telepon sudah terverifikasi
            </label>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('owners.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
@endsection
