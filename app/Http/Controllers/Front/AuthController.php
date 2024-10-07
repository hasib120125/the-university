<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\Admin;
use App\Models\Professor;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]);

        switch ($request->type) {
            case 'admin':
                $user = Admin::where('email', $request->email)->first();
                break;
            case 'professor':
                $user = Professor::where('email', $request->email)->first();
                break;
            default:
                $user = Student::where('email', $request->email)->where('active', 1)->first();
                break;
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->token = $user->createToken($request->device)->plainTextToken;
        $user->type = $request->type;

        return new AuthResource($user);
    }
}
