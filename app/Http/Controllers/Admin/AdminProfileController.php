<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,'.$admin->id,
            'password' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($request->password){
            $admin->password = bcrypt($request->password);
        }

        $admin->photo = $request->file('photo') ? $request->file('photo')->store('admins') : $admin->photo;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        $admin->token = $admin->createToken('web')->plainTextToken;

        return new AdminResource($admin);
    }
}
