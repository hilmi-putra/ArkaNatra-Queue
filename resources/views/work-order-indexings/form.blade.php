@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Antrian Work Orders</h5>
                    <a href="{{ route('admin.work-orders.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Tambah Work Order
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50">#</th>
                                    <th width="120">Ref ID</th>
                                    <th width="80">Antrian</th>
                                    <th>Customer</th>
                                    <th>Divisi</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th width="120">Estimasi Selesai</th>
                                    <th width="100">Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workOrders as $workOrder)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $workOrder->ref_id }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary" style="font-size: 1.1em;">
                                                #{{ $workOrder->antrian_ke }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $workOrder->customer->name }}</strong><br>
                                            <small class="text-muted">{{ $workOrder->customer->email }}</small>
                                        </td>
                                        <td>{{ $workOrder->division->name ?? '-' }}</td>
                                        <td>{{ $workOrder->workType->work_type ?? '-' }}</td>
                                        <td>
                                            @if($workOrder->estimasi_date)
                                                {{ \Carbon\Carbon::parse($workOrder->estimasi_date)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($workOrder->status == 'validate') badge-success
                                                @elseif($workOrder->status == 'pending') badge-warning
                                                @elseif($workOrder->status == 'completed') badge-primary
                                                @elseif($workOrder->status == 'revision') badge-danger
                                                @else badge-secondary @endif">
                                                {{ ucfirst($workOrder->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.work-orders.show', $workOrder->id) }}" 
                                                   class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.work-orders.edit', $workOrder->id) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.work-orders.destroy', $workOrder->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            title="Delete" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus work order ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Tidak ada data work order
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($workOrders->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $workOrders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection