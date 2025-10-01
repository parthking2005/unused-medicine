@extends('admin.layouts.app')

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-money text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Total Donations</div>
                            <div class="stat-digit">{{ $td }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-user text-primary border-primary"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Total Pickups</div>
                            <div class="stat-digit">{{ $tpd }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-layout-grid2 text-pink border-pink"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Yesterday's Donations</div>
                            <div class="stat-digit">{{ $yd }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-link text-danger border-danger"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Total NGOs</div>
                            <div class="stat-digit">{{ $nngo }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('admin-registerngo') }}" class="btn btn-primary btn-block mb-3">
                                    <i class="ti-plus"></i> Register New NGO
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin-registermanager') }}" class="btn btn-success btn-block mb-3">
                                    <i class="ti-user"></i> Register Manager
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin-displayngos') }}" class="btn btn-info btn-block mb-3">
                                    <i class="ti-view-list"></i> View NGOs
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.messages') }}" class="btn btn-warning btn-block mb-3">
                                    <i class="ti-email"></i> View Messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Donations</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Donator</th>
                                        <th>NGO</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Donation::with(['donator', 'ngo'])->latest()->take(5)->get() as $donation)
                                    <tr>
                                        <td>{{ $donation->date }}</td>
                                        <td>{{ $donation->donator->name }}</td>
                                        <td>{{ $donation->ngo->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $donation->status == 'Pending' ? 'warning' : 'success' }}">
                                                {{ $donation->status }}
                                            </span>
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