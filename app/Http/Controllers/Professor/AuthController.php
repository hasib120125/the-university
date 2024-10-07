<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest:professor')->except('logout');
    }

    public function login(Request $request) {
       $request->validate([
           'email' => 'required|email',
           'password' => 'required',
           'device' => 'required',
       ]);

       $professor = Professor::where('email', $request->email)->first();

       if(!$professor || !Hash::check($request->password, $professor->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
       }

       $professor->token = $professor->createToken($request->device)->plainTextToken;

       $professor->type = $request->type;

        return new AuthResource($professor);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout() {
        Auth::guard('professor')->user()->currentAccessToken()->delete();
    }
}
