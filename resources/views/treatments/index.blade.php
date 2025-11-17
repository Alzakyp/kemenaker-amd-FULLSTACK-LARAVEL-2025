@extends('layouts.app')

@section('title', 'Data Treatment - PetCare+')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Treatment</h3>
        <a href="{{ route('treatments.create') }}" class="btn btn-primary">+ Tambah Treatment</a>
    </div>

    @if ($treatments->isEmpty())
        <p>Belum ada data treatment.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Treatment</th>
                        <th>Harga (Rp)</th>
                        <th>Keterangan</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($treatments as $treatment)
                        <tr>
                            <td>{{ $treatment->name }}</td>
                            <td>{{ $treatment->price ? number_format($treatment->price, 0, ',', '.') : '-' }}</td>
                            <td>{{ Str::limit($treatment->description, 60) }}</td>
                            <td class="text-center">
                                <a href="{{ route('treatments.edit', $treatment) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('treatments.destroy', $treatment) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus treatment ini?')">
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

        {{ $treatments->links() }}
    @endif
@endsection
