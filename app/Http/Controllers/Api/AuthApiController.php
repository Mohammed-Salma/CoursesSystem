<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        $data['token'] = $user->createToken('ApiRegisterToken')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        return ApiResponse::send(201, true, 'تم انشاء الحساب بنجاح وتم تسجيل الدخول', $data);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $data['token'] = $user->createToken('ApiLoginToken')->plainTextToken;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            return ApiResponse::send(200, true, 'تم تسجيل الدخول بنجاح', $data);
        } else {
            return ApiResponse::send(401, false, 'البريد الالكتروني او كلمة المرور غير صحيحة');
        }
    }

    public function logout(Request $request)
    {
        // حذف التوكن نهائيا من جدول التوكن
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::send(200, true, 'تم تسجيل الخروج بنجاح');
    }

}
