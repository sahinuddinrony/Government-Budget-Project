@extends('layouts.app')

@section('content')
    <br>

    @if (Session::has('success'))
        <div class="alert alert-success" id="alert">
            {{ Session::get('success') }}
        </div>
    @endif


    <div class="container">
        {{-- <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data"> --}}
        <form method="POST" action="{{ route('status.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- <div class="form-group mb-3">
                <label>Want to approve this User?</label>
                <select name="approve" class="form-control">
                    <option value="">--Select Status--</option>
                    <option value="Active">Active</option>
                    <option value="Deactive">Deactive</option>
                </select>
            </div>

            <!-- Add a hidden input to include the user's ID -->
            <input type="hidden" name="id" value="{{ $user->id }}"> --}}

            <div class="form-group mb-3">
                <label>Want to approve this User?</label>
                <select name="approve" class="form-control">
                    <option value="">--Select Status--</option>
                    <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Deactive" {{ $user->status == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <input type="hidden" name="id" value="{{ $user->id }}">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            }, 5000);
        });
    </script>
@endsection
