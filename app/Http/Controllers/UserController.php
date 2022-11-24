<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UserController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'nama_user' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $user = User::create([
            'id_user' => Uuid::uuid4()->toString(),
            'nama_user' => $fields['nama_user'],
            'username' => $fields['username'],
            'role' => 'Customer',
            'member' => false,
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $token = $user->createToken('tokenku')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check username
        $user = User::where('username', $fields['username'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Akses tidak Sah'
            ], 401);
        }

        $token = $user->createToken('tokenku')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Anda telah Keluar'], 200);
    }

    public function member(Request $request)
    {
        $data = User::where('id_user', $request->user()->id_user)->first();

        if($data->role === 'Admin') {
            return ['message' => 'Anda Bukan Customer'];
        }
        
        if($data) {
            $data->member = true;
            $data->save();

            return $data;
        }else {
            return ['message' => 'Data User tidak Ditemukan'];
        }
    }
}