@extends('layouts.app')

@section('title', 'Data Pemeriksaan - PetCare+')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Pemeriksaan</h3>
        <a href="{{ route('checkups.create') }}" class="btn btn-primary">+ Tambah Pemeriksaan</a>
    </div>

    <form method="GET" action="{{ route('checkups.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">Filter berdasarkan Hewan</label>
            <select name="pet_id" class="form-select">
                <option value="">-- Semua Hewan --</option>
                @foreach ($pets as $pet)
                    <option value="{{ $pet->id }}" {{ request('pet_id') == $pet->id ? 'selected' : '' }}>
                        {{ $pet->name }} ({{ $pet->owner->name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal dari</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal sampai</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-secondary w-100" type="submit">Filter</button>
        </div>
    </form>

    @if ($checkups->isEmpty())
        <p>Belum ada data pemeriksaan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Hewan</th>
                        <th>Pemilik</th>
                        <th>Treatment</th>
                        <th>Berat (kg)</th>
                        <th>Catatan</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkups as $checkup)
                        <tr>
                            <td>{{ $checkup->checkup_date->format('d-m-Y') }}</td>
                            <td>{{ $checkup->pet->name }}</td>
                            <td>{{ $checkup->pet->owner->name }}</td>
                            <td>{{ $checkup->treatment->name }}</td>
                            <td>
                                @if (!is_null($checkup->weight_at_checkup))
                                    {{ number_format($checkup->weight_at_checkup, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ Str::limit($checkup->notes, 60) }}</td>
                            <td class="text-center">
                                <a href="{{ route('checkups.edit', $checkup) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('checkups.destroy', $checkup) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data pemeriksaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $checkups->links() }}
    @endif
@endsection
