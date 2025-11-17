@extends('layouts.app')

@section('title', 'Dashboard - VetClinic Pro')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card stats-card-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pemilik</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $ownerCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card stats-card-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Hewan</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $petCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-heart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card stats-card-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pemeriksaan</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $checkupCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clipboard2-pulse fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold">{{ now()->format('d M Y') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar3 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Checkups -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Pemeriksaan Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentCheckups->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Treatment</th>
                                    <th>Berat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCheckups as $checkup)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $checkup->checkup_date->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-heart text-danger me-2"></i>
                                                <div>
                                                    <strong>{{ $checkup->pet->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $checkup->pet->type }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person text-primary me-2"></i>
                                                {{ $checkup->pet->owner->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $checkup->treatment->name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($checkup->weight_at_checkup)
                                                <strong>{{ $checkup->weight_at_checkup }} kg</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Selesai
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-clipboard2-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">Belum ada pemeriksaan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
