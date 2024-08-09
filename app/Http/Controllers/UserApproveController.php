<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserDeactivatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class UserApproveController extends Controller
{
    public function index()
    {
        // $allUsers = User::where('status','Active')->get();
        // $allUsers = User::all();
        $allUsers = User::withTrashed()->get(); // Include soft deleted users
        return view('status.all_user_status', compact('allUsers'));
    }

    // public function edit(Request $request)
    public function edit($id)
    {
        // return view('status.edit', compact('request'));

        // $user = User::findOrFail($id);
        $user = User::withTrashed()->findOrFail($id);
        return view('status.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // $user = User::where('status','Active')
        //                 ->where('id',$request->id)->first();

        $request->validate([
            'approve' => ['required', 'string', 'in:Active,Deactive'],
            'id' => ['required', 'exists:users,id'],
        ]);

        // $user = User::findOrFail($request->id);
        $user = User::withTrashed()->findOrFail($request->id);

        // $user->status = $request->approve;

        if ($request->approve === 'Deactive') {
            // Update the status to Deactive before soft deleting
            $user->status = 'Deactive';
            $user->save();

            // Soft delete the user
            $user->delete();

            // Send deactivation email
            Mail::to($user->email)->send(new UserDeactivatedMail($user));
        } else {
            // Restore the user if they were previously soft-deleted and set the status to Active
            $user->status = $request->approve;
            $user->restore();

            // Trigger any events for an active user
            event(new Registered($user));

            // Save the user
            $user->save();
        }



        // $user->save();

        // event(new Registered($user));


        return redirect()->route('status.index')->with('success', 'Data is Added Successfully');

        //     return redirect()->back()->with('success', 'Email is Sent Successfully.');

    }
}
