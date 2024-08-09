@extends('layouts.app')

@section('content')
<div class="container">
    <h2> Show Charge</h2>
    <a class="btn btn-primary" href="{{ route('charges.index') }}"> Back</a>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Fiscal Year:</strong>
                {{ $charge->fiscal_year }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Bank Charge:</strong>
                {{ $charge->bank_charge }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Check Fee:</strong>
                {{ $charge->check_fee }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Unspent Refund:</strong>
                {{ $charge->unspent_refund }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Budget Item:</strong>
                {{ $charge->budget->item_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>User:</strong>
                {{ $charge->user->name }}
            </div>
        </div>
    </div>
</div>
@endsection
