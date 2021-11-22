<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::where('id', '!=', auth()->user()->id)->when($request->keyword, function($query, $keyword){
                $query->where('id', '!=', auth()->user()->id)
                        ->where('firstname', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('lastname', 'LIKE', '%'.$keyword.'%')
                        ->orWhereRaw("concat(firstname,' ',lastname)=?",$keyword)
                        ->orWhereRaw("concat(lastname,' ',firstname)=?",$keyword)
                        ->orWhere('username','LIKE', "%{$keyword}%")
                        ->orWhere('email','LIKE', "%{$keyword}%");
            })->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'New User successfully added');
    }

    public function delete(User $user)
    {
        $user->delete();

        return Redirect::route('users.index')->with('success', 'User successfully deleted');
    }

    public function reset(User $user)
    {
        $user->password = Hash::make('12345678');

        return Redirect::route('users.index')->with('success', "$user->username password has been successfully reset");
    }
}
