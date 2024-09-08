@extends('layouts.app')

@section('content')
</br>
<div class="container">
    <h2 class="col-xs-12 col-sm-12 col-md-12 text-center">Edit Charge</h2>
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

    <form action="{{ route('charges.update', $charge->id) }}" method="POST" class="form-horizontal">
        @csrf
        @method('PUT')

        @if(auth()->user()->isAdmin())
            <div class="form-group">
                <label class="col-sm-2 control-label"><strong>Budget Item:</strong></label>
                <div class="col-sm-10">
                    <select name="budget_id" class="form-control" required>
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}" {{ $budget->id == $charge->budget_id ? 'selected' : '' }}>{{ $budget->item_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </br>

            <div class="form-group">
                <label class="col-sm-2 control-label"><strong>User:</strong></label>
                <div class="col-sm-10">
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $charge->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </br>

        @else
            <!-- Hidden budget_id input field for non-admin users -->
            <input type="hidden" name="budget_id" value="{{ $charge->budget_id }}">
        @endif

        {{-- <div class="form-group">
            <label class="col-sm-2 control-label"><strong>Fiscal Year:</strong></label>
            <div class="col-sm-10">
                <select name="fiscal_year" class="form-control">
                    @foreach($fiscalYears as $year)
                        <option value="{{ $year }}" {{ $year == $charge->fiscal_year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </br> --}}

        <div class="form-group">
            <label for="fiscal_year">Fiscal Year</label>
            <input type="text" name="fiscal_year" id="fiscal_year" class="form-control" value="{{ old('fiscal_year', $charge->fiscal_year) }}" required>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>চেক বই উত্তোলন:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="check_fee" class="form-control" value="{{ $charge->check_fee }}" placeholder="Check Fee">
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>ব্যাংক পরিচালনা ফিস:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="bank_charge" class="form-control" value="{{ $charge->bank_charge }}" placeholder="Bank Charge">
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>অব্যয়িত অর্থ ফেরত:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="unspent_refund" class="form-control" value="{{ $charge->unspent_refund }}" placeholder="Unspent Refund">
            </div>
        </div>
        </br>

        <div class="form-group">
            <label class="col-sm-2 control-label"><strong>হস্তে মজুদ অথবা ব্যাংকে অবশিষ্ট অব্যয়িত অর্থ:</strong></label>
            <div class="col-sm-10">
                <input type="number" name="unspent_money" class="form-control" value="{{ $charge->unspent_money }}" placeholder="Unspent Refund">
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
