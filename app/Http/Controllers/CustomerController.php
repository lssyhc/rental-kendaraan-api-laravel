<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $dataCustomer = User::where('role', 'Customer')->get();

        return response()->json([
            'message' => 'Data Customer Sukses Dimuat',
            'data' => $dataCustomer
        ], 200);
    }

    public function show($id_customer)
    {
        $data = User::where('id_user', $id_customer)->where('role', 'Customer')->get();
        if(count($data) > 0) {
            return $data;
        }else {
            return ['message' => 'Data Customer tidak Ditemukan'];
        }
    }

    public function update(Request $request, $id_customer)
    {
        $fields = $request->validate([
            'nama_user' => 'nullable|string',
            'username' => 'nullable|string|unique:users,username',
            'member' => 'nullable|boolean',
            'email' => 'nullable|string|unique:users,email',
            'password' => 'nullable|string|confirmed|min:6'
        ]);
        
        $data = User::where('id_user', $id_customer)->where('role', 'Customer')->first();
        if($data) {
            $data->nama_user = $request->nama_user ? $fields['nama_user'] : $data->nama_user;
            $data->username = $request->username ? $fields['username'] : $data->username;
            $data->member = $request->member ? $fields['member'] : $data->member;
            $data->email = $request->email ? $fields['email'] : $data->email;
            $data->password = $request->password ? bcrypt($fields['email']) : $data->password;
            $data->update_at = date('Y-m-d H:i:s');
            $data->save();

            return $data;
        }else {
            return ['message' => 'Data Customer tidak Ditemukan'];
        }
    }

    public function destroy($id_customer)
    {
        $data = User::where('id_user', $id_customer)->where('role', 'Customer')->first();
        if($data) {
            $data->delete();
            return ['message' => 'Data Customer Berhasil Dihapus'];
        }else {
            return ['message' => 'Data Customer tidak Ditemukan'];
        }
    }
}
