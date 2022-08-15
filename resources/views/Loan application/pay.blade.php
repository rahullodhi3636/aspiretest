@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Installment payment detail') }}

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
                    <form method="post" action="{{ route('loan_application/pay') }}">
                        @csrf
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" value="{{$user->name}}" readonly="true">
                            <input type="hidden" name="installment_id" class="form-control" value="{{$installment_id}}">
                        </div>

                        <div class="form-group">
                            <label>Loan amount</label>
                            <input type="number" name="installment_amount" class="form-control" step=any value="{{ old('installment_amount',$lapp_detail->installment_amount)}}">
                            @if ($errors->has('loan_amount'))<span class="text-danger">{{ $errors->first('loan_amount') }}</span>@endif
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
