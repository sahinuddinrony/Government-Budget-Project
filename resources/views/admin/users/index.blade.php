<!-- resources/views/admin/users/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Users Pending Approval</h1>
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif
    <ul>
        @foreach ($users as $user)
            <li>
                {{ $user->name }} ({{ $user->email }})
                <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit">Approve</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
