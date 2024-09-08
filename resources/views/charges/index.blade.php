@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        {{-- <h2>Charges</h2> --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- <a href="{{ route('charges.create') }}" class="btn btn-primary mb-3">Add Charge</a> --}}
        <table class="table table-bordered">
            <tr>
                <th>ক্রমিক</th>
                <th>অর্থবছর</th>
                <th>ব্যাংক পরিচালনা ফিস</th>
                <th>চেক বই উত্তোলন</th>
                <th>অব্যয়িত অর্থ ফেরত</th>
                <th>সর্বমোট খরচ</th>
                {{-- <th>Budget Item</th> --}}
                {{-- <th>User</th> --}}
                <th width="280px">Action</th>
            </tr>
            @foreach ($charges as $charge)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $charge->fiscal_year }}</td>
                    <td>{{ $charge->bank_charge }}</td>
                    <td>{{ $charge->check_fee }}</td>
                    <td>{{ $charge->unspent_refund }}</td>
                    <td>#</td>
                    {{-- <td>{{ $charge->budget->item_name }}</td> --}}
                    {{-- <td>{{ $charge->user->name }}</td> --}}
                    <td>
                        <a class="btn btn-info" href="{{ route('charges.show', $charge->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('charges.edit', $charge->id) }}">Edit</a>

                        <form action="{{ route('charges.destroy', $charge->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" onclick="return confirm('Are you sure?')"
                                class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><strong> অর্থবছরের হস্তে মজুদ অথবা ব্যাংকে অবশিষ্ট অব্যয়িত অর্থ </strong></td>
                    <td colspan="3"><strong>{{ $charge->unspent_money }}</strong></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
