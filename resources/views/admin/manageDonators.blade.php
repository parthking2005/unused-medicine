@extends('admin.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Manage Donators</h4>
                </div>
            </div>
        </div>

        @include('partial.customerror')
        @include('partial.success')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Donators with Bad Feedback</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Donator Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Feedback Category</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                    <tr>
                                        <td>{{ $record->donator->name }}</td>
                                        <td>{{ $record->donator->email }}</td>
                                        <td>{{ $record->donator->contact }}</td>
                                        <td>{{ $record->feedback->category->name }}</td>
                                        <td>{{ $record->feedback->description }}</td>
                                        <td>
                                            <a href="{{ route('BlockDonator-Admin', $record->donator_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to block this donator?')">
                                                Block
                                            </a>
                                            <a href="{{ route('WarnDonator-Admin', $record->donator_id) }}" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to warn this donator?')">
                                                Warn
                                            </a>
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