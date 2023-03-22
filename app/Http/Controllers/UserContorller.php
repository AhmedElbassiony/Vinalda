<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserContorller extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        return datatables(User::all())
            ->addColumn('actions', 'user.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|numeric|digits:11|unique:users,mobile',
            'password' => 'required|min:6|max:50',
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => $data['password'],
        ]);

        session()->flash('success', 'تم اضافة المستخدم بنجاح');
        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|numeric|digits:11|unique:users,mobile,' . $user->id,
            'password' => 'nullable|min:6|max:50',
        ]);

        if (isset($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $user->password;
        }

        $user->update(
            ['name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => $data['password'],
        ]);

        session()->flash('success', 'تم تعديل المستخدم بنجاح');
        return redirect()->route('user.index');
    }

    public function generatePassword()
    {
        return generateRandomString();
    }
}


