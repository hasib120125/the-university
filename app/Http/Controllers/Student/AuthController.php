<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest:student')->except('logout');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $student->token = $student->createToken($request->device)->plainTextToken;

        $student->type = $request->type;

        return new AuthResource($student);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout() {
        Auth::guard('student')->user()->currentAccessToken()->delete();
    }
}
