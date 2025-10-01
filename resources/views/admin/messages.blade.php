@extends('admin.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Contact Messages</h4>
                </div>
            </div>
        </div>

        @include('partial.customerror')
        @include('partial.success')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Messages</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr>
                                        <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ Str::limit($message->message, 50) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $message->visibility ? 'warning' : 'success' }}">
                                                {{ $message->visibility ? 'Unread' : 'Read' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.messages.visibility', $message->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-{{ $message->visibility ? 'success' : 'warning' }} btn-sm">
                                                    {{ $message->visibility ? 'Mark as Read' : 'Mark as Unread' }}
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
    </div>
</div>
@endsection
