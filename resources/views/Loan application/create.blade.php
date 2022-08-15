@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Add new Loan application') }}
                    <a href="{{ route('loan_application')}}" class="btn btn-primary btn-sm" style="float: right">Load Application</a>
                </div>


                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('loan_application/create') }}">
                        @csrf
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" value="{{$user->name}}" readonly="true">
                        </div>
                        <div class="form-group">
                            <label>Loan Type</label>
                            <select class="form-control" name="loan_type">
                                  <option value="">--select--</option>
                                  <option value="Home">Home</option>
                                  <option value="Car">Car</option>
                                  <option value="Personal">Personal</option>
                            </select>
                            @if ($errors->has('loan_type'))<span class="text-danger">{{ $errors->first('loan_type') }}</span>@endif
                        </div>
                        <div class="form-group">
                            <label>Loan amount</label>
                            <input type="number" name="loan_amount" class="form-control" step=any>
                            @if ($errors->has('loan_amount'))<span class="text-danger">{{ $errors->first('loan_amount') }}</span>@endif
                        </div>
                        <div class="form-group">
                            <label>Loan term</label>
                            <input type="number" name="loan_term" class="form-control" min="1" max="12">
                            @if ($errors->has('loan_term'))<span class="text-danger">{{ $errors->first('loan_term') }}</span>@endif
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Submit" style="float: right;margin-top:10px">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
