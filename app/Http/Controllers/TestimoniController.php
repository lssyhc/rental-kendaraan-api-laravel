<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class TestimoniController extends Controller
{
    public function index()
    {
        $data = Testimoni::all();

        return response()->json([
            'message' => 'Data Testimoni Sukses Dimuat',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $transaksi = Transaksi::where('id_customer', $request->user()->id_user)->first();

        if(!$transaksi) return response()->json(['message' => 'Anda Belum Pernah Melakukan Transaksi'], 403);
        
        $data = new Testimoni();
        $data->id_testimoni = Uuid::uuid4()->toString();
        $data->id_customer = $request->user()->id_user;
        $data->id_kendaraan = $transaksi->id_kendaraan;
        $data->merk = $transaksi->merk;
        $data->tarif = $transaksi->tarif;
        $data->konten = $request->konten;
        $data->bintang = $request->bintang;
        $data->created_at = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'message' => 'Data Testimoni Berhasil Ditambahkan',
            'data' => $data
        ], 201);
    }
}
