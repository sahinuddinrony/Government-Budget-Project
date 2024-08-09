@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Charges</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <a href="{{ route('charges.create') }}" class="btn btn-primary mb-3">Add Charge</a>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Fiscal Year</th>
            <th>Bank Charge</th>
            <th>Check Fee</th>
            <th>Unspent Refund</th>
            {{-- <th>Budget Item</th> --}}
            <th>User</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($charges as $charge)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $charge->fiscal_year }}</td>
            <td>{{ $charge->bank_charge }}</td>
            <td>{{ $charge->check_fee }}</td>
            <td>{{ $charge->unspent_refund }}</td>
            {{-- <td>{{ $charge->budget->item_name }}</td> --}}
            <td>{{ $charge->user->name }}</td>
            <td>
                <form action="{{ route('charges.destroy', $charge->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('charges.show', $charge->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('charges.edit', $charge->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
