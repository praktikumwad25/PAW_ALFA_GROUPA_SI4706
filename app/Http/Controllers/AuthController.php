<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    //TODO
    //Buat fungsi Register agar user dapat mendaftarkan akunnya dan mendapatkan Token
    public function signup(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator-errors()], 401);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('TokDeTok')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'user registered success!',
            'token' => $token,
            'user' => $user,
        ]);

    }

    //TODO
    //Buat fungsi login agar user dapat login pada akun yang telah terdaftar dan mendapatkan Token
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('TokDeTok')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'user login success!',
            'token' => $token,
            'user' => $user,
        ]);

    }

    //TODO
    //Buat fungsi logout agar user dapat keluar dari akunnya ketika tidak digunakan
    public function logout(Request $request) {
        $request->user()->token()->delete();

        return response()->json([
            'success' => true,
            'message' => 'berhasil logout!',
        ]);
    }

}