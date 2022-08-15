@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Loan Installment list') }}
                    @if($user->role==0)
                    <a href="{{ route('loan_application')}}" class="btn btn-primary btn-sm" style="float: right">Loan application</a>
                    @endif
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
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>Amount</td>
                                <td>Due Date</td>
                                <td>Payment Status</td>
                                <td>Paid amount</td>
                                <td>Paid Date</td>
                                @if($user->role==0)
                                <td>Actions</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($loan_application as $key => $value)
                            <tr>
                                <td>{{ $value->installment_amount }}</td>
                                <td>{{ $value->payment_date }}</td>
                                <td>
                                    @php
                                        if($value->installment_status=='0'){
                                            echo '<span class="text-danger">Pending</span>';
                                        }else{
                                            echo '<span class="text-success">Paid</span>';
                                        }
                                    @endphp
                                </td>
                                <td>{{ $value->installment_paid_amount}}</td>
                                <td>
                                    @if($value->installment_status=='1')
                                    {{ $value->installment_paid_date}}
                                    @endif
                                </td>
                                <td>
                                    @if($user->role==0)
                                            @if($lapp->loan_status==1)
                                                @if($value->installment_status=='0')
                                                    <a class="btn btn-small btn-success" target="_blank" href="{{ URL::to('pay/' . $value->id) }}">Pay </a>
                                                @else
                                                    <span class="text-success">Paid</span>
                                                @endif
                                            @else
                                            <span class="text-danger">Waiting to approval for pay</span>
                                            @endif
                                    @endif
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
@endsection
