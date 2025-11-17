@extends('layouts.app')

@section('title', 'Dashboard - VetClinic Pro')

@section('content')
<!-- Welcome Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
            <p>Selamat datang di VetClinic Pro - Sistem manajemen hewan terpadu</p>
        </div>
        <div class="d-none d-md-block">
            <div class="text-end">
                <div class="fs-4 fw-bold">{{ now()->format('H:i') }}</div>
                <div class="opacity-75">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-card-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Total Pemilik</div>
                        <div class="stats-number">{{ $ownerCount }}</div>
                        <small class="opacity-75">
                            <i class="bi bi-arrow-up"></i> Terdaftar
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-card-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Total Hewan</div>
                        <div class="stats-number">{{ $petCount }}</div>
                        <small class="opacity-75">
                            <i class="bi bi-heart-fill"></i> Terawat
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-card-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Total Pemeriksaan</div>
                        <div class="stats-number">{{ $checkupCount }}</div>
                        <small class="opacity-75">
                            <i class="bi bi-clipboard2-pulse"></i> Selesai
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-card-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-label">Hari Ini</div>
                        <div class="stats-number" style="font-size: 1.5rem;">{{ now()->format('d') }}</div>
                        <small class="opacity-75">
                            {{ now()->isoFormat('MMMM Y') }}
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-modern">
            <div class="card-header-modern">
                <i class="bi bi-lightning-charge-fill me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('pets.create') }}" class="btn btn-primary-modern btn-modern w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Hewan
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('owners.create') }}" class="btn btn-outline-primary btn-modern w-100">
                            <i class="bi bi-person-plus-fill me-2"></i>Tambah Pemilik
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('checkups.create') }}" class="btn btn-outline-success btn-modern w-100">
                            <i class="bi bi-clipboard-plus-fill me-2"></i>Pemeriksaan Baru
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('treatments.create') }}" class="btn btn-outline-info btn-modern w-100">
                            <i class="bi bi-bandaid-fill me-2"></i>Tambah Treatment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Checkups -->
<div class="row">
    <div class="col-12">
        <div class="card card-modern">
            <div class="card-header-modern d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-clock-history me-2"></i>Pemeriksaan Terbaru
                </div>
                <a href="{{ route('checkups.index') }}" class="btn btn-sm btn-outline-primary btn-modern">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentCheckups->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-calendar3 me-1"></i>Tanggal</th>
                                    <th><i class="bi bi-heart me-1"></i>Hewan</th>
                                    <th><i class="bi bi-person me-1"></i>Pemilik</th>
                                    <th><i class="bi bi-bandaid me-1"></i>Treatment</th>
                                    <th><i class="bi bi-speedometer me-1"></i>Berat</th>
                                    <th><i class="bi bi-check-circle me-1"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCheckups as $checkup)
                                    <tr>
                                        <td>
                                            <div class="badge badge-modern bg-primary">
                                                {{ $checkup->checkup_date->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="bi bi-heart-fill text-danger"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $checkup->pet->name }}</div>
                                                    <small class="text-muted">{{ $checkup->pet->type }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="bi bi-person-fill text-primary"></i>
                                                </div>
                                                {{ $checkup->pet->owner->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-modern bg-success">
                                                {{ $checkup->treatment->name }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($checkup->weight_at_checkup)
                                                <span class="fw-semibold">{{ $checkup->weight_at_checkup }} kg</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="badge badge-modern bg-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-clipboard2-x text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-muted">Belum ada pemeriksaan</h5>
                        <p class="text-muted mb-0">Pemeriksaan akan muncul di sini setelah ditambahkan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
