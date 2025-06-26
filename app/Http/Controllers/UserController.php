<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index
    public function admin(Request $request)
    {
        //get all users with pagination
        $users = DB::table('users')
            ->whereIn('role', ['admin','staff'])
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->whereIn('role', ['admin','staff'])
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);
        return view('pages.users.admin', compact('users'));
    }
    public function index(Request $request)
    {
        //get all users with pagination
        $users = DB::table('users')
        ->where('role', 'user')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                ->where('role', 'user')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    // create
    public function create()
    {
        return view('pages.users.create');
    }

    // store
    public function store(Request $request)
    {
        // validate the request...
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'business_name' => 'nullable',
            'role' => 'required|in:admin,staff',
        ]);

        // store the request...
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->business_name = '-';
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User created successfully');
    }

    // show
    // public function show($id)
    // {
    //     return view('pages.users.show');
    // }

    // edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    // update
    public function update(Request $request,$id)
    {
        // validate the request...
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'business_name' => 'nullable',
            'role' => 'required|in:admin,staff',
        ]);
        
        dd($request);
        // update the request...
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->business_name = $request->business_name;
        $user->role = $request->role ;
        $user->update();

        //if password is not empty
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->update();
        }
        return back();
        // return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request...
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
