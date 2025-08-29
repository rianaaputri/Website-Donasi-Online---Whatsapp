@extends('layouts.admin')

@section('title', 'Laporan Donasi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Donasi</h1>
        <div class="d-flex gap-2">
            <a href="" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Analytics
            </a>
            <button type="button" class="btn btn-success btn-sm" onclick="exportDonations()">
                <i class="fas fa-download"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Donasi Sukses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['total_donations'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Donasi Sukses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['success_donations']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Donasi Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['pending_donations']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Donasi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['today_donations'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('donation.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="campaign_id">Campaign</label>
                            <select name="campaign_id" id="campaign_id" class="form-control">
                                <option value="">Semua Campaign</option>
                                @foreach($campaigns as $campaign)
                                    <option value="{{ $campaign->id }}" 
                                        {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                        {{ $campaign->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Tanggal Dari</label>
                            <input type="date" name="date_from" id="date_from" 
                                   class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Tanggal Sampai</label>
                            <input type="date" name="date_to" id="date_to" 
                                   class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search">Cari Donatur</label>
                            <input type="text" name="search" id="search" 
                                   class="form-control" placeholder="Nama atau email donatur..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group w-100">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('donation.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Donations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Donasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Campaign</th>
                            <th>Donatur</th>
                            <th>Phone</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('campaign.show', $donation->campaign->id) }}" 
                                       target="_blank" class="text-decoration-none">
                                        {{ Str::limit($donation->campaign->title, 30) }}
                                    </a>
                                </td>
                                <td>
                                    @if($donation->user)
                                        {{ $donation->user->name }}
                                    @else
                                        {{ $donation->donor_name ?? 'Guest' }}
                                    @endif
                                </td>
                                <td>
                                       @if($donation->user)
                    {{ $donation->user->phone }}
                @else
                    {{ $donation->donor_phone ?? '-' }}
                @endif
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($donation->payment_status == 'success')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Success
                                        </span>
                                    @elseif($donation->payment_status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Failed
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $donation->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-4">
                                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Tidak ada data donasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $donations->firstItem() ?? 0 }} sampai {{ $donations->lastItem() ?? 0 }} 
                    dari {{ $donations->total() }} hasil
                </div>
                {{ $donations->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportDonations() {
    const params = new URLSearchParams(window.location.search);
    const exportUrl = '/admin/donations/export?' + params.toString();
    window.location.href = exportUrl;
}

$(document).ready(function() {
    $('#dataTable').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": true,
        "order": [[ 6, "desc" ]], // urutkan berdasarkan tanggal
        "columnDefs": [
            { "orderable": false, "targets": [0,1,2,3,4,5] }
        ]
    });
});
</script>
@endpush
