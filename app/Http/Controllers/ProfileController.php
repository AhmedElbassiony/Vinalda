<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function create(User $user)
    {
        return view('profile.create' , compact('user'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'oldPassword' => 'sometimes|min:6',
            'password' => 'nullable|confirmed|min:6',
            'password_confirmation' => 'same:password'
        ]);

        if (Hash::check($request->oldPassword, auth()->user()->password)) {
            if (isset($request->password)) {
                $password = bcrypt($request->password);
            } else {
                $password = auth()->user()->password;
            }
        } else {
            session()->flash('error', 'تاكد من كلمة السر القديمة');
            return redirect()->route('profile.create');
        }

        auth()->user()->update(['password' => $password]);
        session()->flash('success', 'تم تعديل كلمة السر بنجاح');
        return redirect()->route('dashboard');
    }
}
