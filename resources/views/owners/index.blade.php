@extends('layouts.app')

@section('title', 'Data Pemilik - PetCare+')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Pemilik</h3>
        <a href="{{ route('owners.create') }}" class="btn btn-primary">+ Tambah Pemilik</a>
    </div>

    @if ($owners->isEmpty())
        <p>Belum ada data pemilik.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Verifikasi</th>
                        <th>Alamat</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($owners as $owner)
                        <tr>
                            <td>{{ $owner->name }}</td>
                            <td>{{ $owner->phone }}</td>
                            <td>
                                @if ($owner->is_phone_verified)
                                    <span class="badge text-bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge text-bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td>{{ $owner->address }}</td>
                            <td class="text-center">
                                <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('owners.destroy', $owner) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus pemilik ini?')">
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

        {{ $owners->links() }}
    @endif
@endsection
