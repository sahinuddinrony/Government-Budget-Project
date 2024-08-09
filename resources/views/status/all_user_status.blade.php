{{-- <!doctype html>
<html lang="en"> --}}

@extends('layouts.app')

    @section('content')
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>User, Show!</title>
</head>

<body>


    {{-- <div class="text-center">
        <h1>Message Send All</h1>
        <p>New Anouncment Send to All Subscribe.</p>
        <a href="{{ route('subscriber_send_email') }}">
          <button class="btn btn-md btn-success"> Message</button>
        </a>
      </div> --}}

    <br><br>
    <div class="section-body">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Date and Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allUsers as $allUser)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $allUser->name }}</td>
                                            <td>{{ $allUser->email }}</td>
                                            <td>{{ $allUser->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ $allUser->status }}</td>
                                            <td>
                                                <a href="{{ route('status.edit', $allUser) }}">Edit</a>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

@endsection

{{-- </html> --}}
