<?php

namespace App\Http\Controllers;

use App\Models\Chatting;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class ChattingController extends Controller
{
    public function store(Request $request)
    {
        $data = new Chatting();
        
        $data->id_chat = Uuid::uuid4()->toString();;
        $data->id_customer = $request->user()->id_user;
        $data->konten = $request->konten;
        $data->created_at = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'message' => 'Customer Berhasil Membuat Data Chatting',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id_chat)
    {
        $data = Chatting::where('id_chat', $id_chat)->first();
        if($data) {
            $data->id_admin = $request->user()->id_user;
            $data->balasan = $request->balasan;
            $data->update_at = date('Y-m-d H:i:s');
            $data->save();

            return $data;
        }else {
            return ['message' => 'Admin Berhasil Membalas Chat'];
        }
    }
}
