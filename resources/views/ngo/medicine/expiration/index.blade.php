@extends('ngo.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Medicine Expiration Management</h4>
                </div>
            </div>
        </div>

        @include('partial.customerror')
        @include('partial.success')

        <!-- Expiring Soon Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Medicines Expiring Soon</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Brand</th>
                                        <th>Quantity</th>
                                        <th>Expiry Date</th>
                                        <th>Days Left</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringSoon as $item)
                                    <tr>
                                        <td>{{ $item->medicineStock->medicine->name }}</td>
                                        <td>{{ $item->medicineStock->medicine->brand }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expiry_date->format('Y-m-d') }}</td>
                                        <td>{{ $item->expiry_date->diffInDays(now()) }}</td>
                                        <td>
                                            <form action="{{ route('medicine.expiration.dispose', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to dispose this medicine?')">
                                                    Dispose
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Expired Medicines</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Brand</th>
                                        <th>Quantity</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expired as $item)
                                    <tr>
                                        <td>{{ $item->medicineStock->medicine->name }}</td>
                                        <td>{{ $item->medicineStock->medicine->brand }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expiry_date->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge badge-danger">Expired</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('medicine.expiration.dispose', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="text" name="disposal_notes" class="form-control form-control-sm" placeholder="Disposal notes">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Dispose
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
