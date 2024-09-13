@extends('layouts.app')

@section('content')

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">

            <!-- Left side menu -->
            <div class="w-1/4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-800">Menu</h3>
                        <div class="mt-4">
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('budgets.index') }}"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        সব বাজেটের তালিকা
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('charges.index') }}"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        ব্যাংক চার্জের তথ্য
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-button">
                                            বাজেট রিপোর্ট
                                            <i class="fas fa-chevron-down ml-2"></i>
                                        </button>
                                        <div class="dropdown-list">
                                            <a href="{{ route('search.showSearchForm') }}">অর্থবছর ভিত্তিক সাঃ রিপোর্ট</a>
                                            <a href="{{ route('search.summary') }}">বাজেটের সারাংশ রিপোর্ট</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>


    <div class="container">
        <br>
          <br>
        {{-- <h2>Charges</h2> --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($role === \App\Constants\Role::ADMIN)
            <table class="table table-bordered">
                <tr>
                    <th>ক্রমিক</th>
                    <th>User</th>
                    <th>অর্থবছর</th>
                    <th>ব্যাংক পরিচালনা ফিস</th>
                    <th>চেক বই উত্তোলন</th>
                    <th>অব্যয়িত অর্থ ফেরত</th>
                    <th>সর্বমোট খরচ</th>
                    {{-- <th>Budget Item</th> --}}

                    <th width="280px">Action</th>
                </tr>
                @foreach ($charges as $charge)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $charge->user->name }}</td>
                        <td>{{ $charge->fiscal_year }}</td>
                        <td>{{ $charge->bank_charge }}</td>
                        <td>{{ $charge->check_fee }}</td>
                        <td>{{ $charge->unspent_refund }}</td>
                        <td>{{ $charge->bank_charge + $charge->check_fee + $charge->unspent_refund }}</td>
                        {{-- <td>{{ $charge->budget->item_name }}</td> --}}

                        <td>
                            <a class="btn btn-info" href="{{ route('charges.show', $charge->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('charges.edit', $charge->id) }}">Edit</a>

                            <form action="{{ route('charges.destroy', $charge->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><strong> অর্থবছরের হস্তে মজুদ অথবা ব্যাংকে অবশিষ্ট অব্যয়িত অর্থ </strong></td>
                        <td colspan="1"><strong>{{ $charge->unspent_money }}</strong></td>
                    </tr>
                @endforeach
            </table>
        @else
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
                        <td>{{ $charge->bank_charge + $charge->check_fee + $charge->unspent_refund }}</td>
                        {{-- <td>{{ $charge->budget->item_name }}</td> --}}
                        {{-- <td>{{ $charge->user->name }}</td> --}}
                        <td>
                            <a class="btn btn-info" href="{{ route('charges.show', $charge->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('charges.edit', $charge->id) }}">Edit</a>

                            <form action="{{ route('charges.destroy', $charge->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><strong> অর্থবছরের হস্তে মজুদ অথবা ব্যাংকে অবশিষ্ট অব্যয়িত অর্থ </strong></td>
                        <td colspan="1"><strong>{{ $charge->unspent_money }}</strong></td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
        </div>
</div>
@endsection
