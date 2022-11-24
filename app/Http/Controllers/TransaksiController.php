<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::all();

        return response()->json([
            'message' => 'Data Transaksi Sukses Dimuat',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $kendaraan = Kendaraan::where('id_kendaraan', $request->id_kendaraan)->first();
        
        $data = new Transaksi();
        $data->id_transaksi = Uuid::uuid4()->toString();
        $data->id_customer = $request->user()->id_user;
        $data->id_kendaraan = $request->id_kendaraan;
        $data->nomor_kendaraan = $kendaraan->nomor_polisi;
        $data->merk = $kendaraan->merk;
        $data->tarif = $kendaraan->tarif;
        $data->created_at = date('Y-m-d H:i:s');
        $data->save();

        // return $data;
        return response()->json([
            'message' => 'Data Transaksi Berhasil Ditambahkan',
            'data' => $data
        ], 201);
    }

    public function show($id_transaksi)
    {
        $data = Transaksi::where('id_transaksi', $id_transaksi)->first();
        if($data) {
            return $data;
        }else {
            return ['message' => 'Data Transaksi tidak Ditemukan'];
        }
    }
}
