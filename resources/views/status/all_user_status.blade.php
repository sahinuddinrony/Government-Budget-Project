@extends('layouts.app')

@section('content')
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
                                                <a href="{{ route('status.edit', $allUser) }}" class="btn btn-primary">Edit</a>
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
@endsection
