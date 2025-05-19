<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller {
    //TODO
    //Buat fungsi Register agar user dapat mendaftarkan akunnya dan mendapatkan Token
$validator = Validator::make(data: $request->all(), rules: [
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
]);

if ($validator->fails()) {
    return respons()->json(data: ['érror' => $validator->errors()], status: 422);
}
$token = $user->createToken('ALAMAK')->plainTestToken();
return response()->json(data: [
    'success' => true,
    'message' => 'User Created',
    'token' => $token,
    'user' => $user,
]);
    //TODO
    //Buat fungsi login agar user dapat login pada akun yang telah terdaftar dan mendapatkan Token
if (Auth::attempt(credentials: $request->only('email', 'password'))) {
    return response()->json(data: ['error' => 'Unauthorized'], status: 401);
}
$user = Auth::user();
$token = $user->createToken('ALAMAK')->plainTextToken();
return response()->json(data: [
    'success' => true,
    'message' => 'User Logged In',
    'token' => $token,
    'user' => $user,
]);
    //TODO
    //Buat fungsi logout agar user dapat keluar dari akunnya ketika tidak digunakan
    $request->user()->currentAccessToken()->delete();
    return response()->json(data: [
        'success' => true,
        'message' => 'User Logged Out',
    ]);
}