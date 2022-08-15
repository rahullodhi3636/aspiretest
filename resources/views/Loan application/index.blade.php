@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Loan application list') }}
                    @if($user->role==0)
                    <a href="{{ route('loan_application/create')}}" class="btn btn-primary btn-sm" style="float: right">Add New application</a>
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
                                <td>ID</td>
                                <td>Name</td>
                                <td>Loan Type</td>
                                <td>Loan amount</td>
                                <td>Loan term</td>
                                <td>Loan status</td>
                                <td>Loan Payment status</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($loan_application as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->user->name }}</td>
                                <td>{{ $value->loan_type }}</td>
                                <td>{{ $value->loan_amount }}</td>
                                <td>{{ $value->loan_term }}</td>
                                <td>
                                    @php
                                        if($value->loan_status=='0'){
                                            echo '<span class="text-danger">Pending</span>';
                                        }else{
                                            echo '<span class="text-success">Approved</span>';
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if($value->loan_payment_status=='0'){
                                            echo '<span class="text-danger">Pending</span>';
                                        }else{
                                            echo '<span class="text-success">Paid</span>';
                                        }
                                    @endphp
                                </td>

                                <td>

                                    @if($user->role==0)
                                        <a class="btn btn-small btn-success" href="{{ URL::to('loan_application/' . $value->id) }}">Show installment </a>
                                    @elseif($user->role==1)
                                        @if( $value->loan_status==0)
                                        <a class="btn btn-small btn-success" href="{{ URL::to('loan_application/approve/' . $value->id) }}">Approve</a>
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
