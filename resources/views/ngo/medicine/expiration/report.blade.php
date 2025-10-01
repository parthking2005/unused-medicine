@extends('ngo.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Disposed Medicines Report</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Disposed Medicines History</h4>
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
                                        <th>Disposed Date</th>
                                        <th>Disposal Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($disposedMedicines as $item)
                                    <tr>
                                        <td>{{ $item->medicineStock->medicine->name }}</td>
                                        <td>{{ $item->medicineStock->medicine->brand }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expiry_date->format('Y-m-d') }}</td>
                                        <td>{{ $item->disposed_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $item->disposal_notes ?? 'No notes' }}</td>
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
