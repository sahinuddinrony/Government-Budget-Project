@extends('layouts.app')

@section('content')
</br>
<div class="container">
    <h2 class="col-xs-12 col-sm-12 col-md-12 text-center">Add New Charge</h2>
</br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('charges.store') }}" method="POST" class="form-horizontal">
        @csrf

        @if(auth()->user()->isAdmin())
            <div class="form-group">
                <label class="col-sm-2 control-label"><strong>Budget Item:</strong></label>
                <div class="col-sm-10">
                    <select name="budget_id" class="form-control">
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}">{{ $budget->item_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </br>

            <div class="form-group">
                <label class="col-sm-2 control-label"><strong>User:</strong></label>
                <div class="col-sm-10">
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </br>
        @endif

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>Fiscal Year:</strong></label>
            <div class="col-sm-10">
                <select name="fiscal_year" class="form-control">
                    @foreach($fiscalYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>চেক বই উত্তোলন:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="check_fee" class="form-control" placeholder="Check Fee">
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>ব্যাংক পরিচালনা ফিস:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="bank_charge" class="form-control" placeholder="Bank Charge">
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>অব্যয়িত অর্থ ফেরত:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="unspent_refund" class="form-control" placeholder="Unspent Refund">
            </div>
        </div>
        </br>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-left">
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
