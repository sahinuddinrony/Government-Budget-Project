<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalMail;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('approved', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->approved = true;
            $user->save();

            // Send the email verification link
            Mail::to($user->email)->send(new ApprovalMail($user));

            return redirect()->back()->with('status', 'User approved successfully.');
        }

        return redirect()->back()->with('error', 'User not found.');
    }
}
