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
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed']
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
    }


    //TODO
    //Buat fungsi login agar user dapat login pada akun yang telah terdaftar dan mendapatkan Token
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required','min:8']
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
               'success' => true,
               'message' => 'Login Berhasil',
               'access_token' => $token,
               'token_type' => 'Bearer'
            ], 200);
        } else {
            return response()->json(['error' => 'Email atau password salah'], 401);
        }
    }

    //TODO
    //Buat fungsi logout agar user dapat keluar dari akunnya ketika tidak digunakan
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
           'success' => true,
           'message' => 'Logout Berhasil'
        ], 200);
    }
}
