@extends('admin.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Medicine Stock</h4>
                </div>
            </div>
        </div>

        @include('partial.customerror')
        @include('partial.success')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Select NGO</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('SelectMedicineCategory-Admin') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">NGO</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="ngo_id" name="ngo_id" required>
                                        <option value="">--select NGO--</option>
                                        @foreach($ngos as $ngo)
                                        <option value="{{ $ngo->id }}" {{ isset($ngoid) && $ngoid == $ngo->id ? 'selected' : '' }}>{{ $ngo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">View Stock</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($medicinestocks))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Medicine Stock for Selected NGO</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicinestocks as $medicinestock)
                                    <tr>
                                        <td>{{ $medicinestock->medicine->name }}</td>
                                        <td>{{ $medicinestock->medicine->brand }}</td>
                                        <td>{{ $medicinestock->medicine->category->name }}</td>
                                        <td>{{ $medicinestock->qty }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection