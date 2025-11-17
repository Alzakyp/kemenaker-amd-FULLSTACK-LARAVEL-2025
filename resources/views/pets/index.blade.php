@extends('layouts.app')

@section('title', 'Data Hewan - PetCare+')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Hewan</h3>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">+ Tambah Hewan</a>
    </div>

    <form method="GET" action="{{ route('pets.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">Filter berdasarkan Pemilik</label>
            <select name="owner_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Pemilik --</option>
                @foreach ($owners as $owner)
                    <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                        {{ $owner->name }} ({{ $owner->phone }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if ($pets->isEmpty())
        <p>Belum ada data hewan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Hewan</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Usia (tahun)</th>
                        <th>Berat (kg)</th>
                        <th>Pemilik</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr>
                            <td>{{ $pet->code }}</td>
                            <td>{{ $pet->name }}</td>
                            <td>{{ $pet->type }}</td>
                            <td>{{ $pet->age }}</td>
                            <td>{{ number_format($pet->weight, 2) }}</td>
                            <td>{{ $pet->owner->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus hewan ini?')">
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

        {{ $pets->links() }}
    @endif
@endsection
