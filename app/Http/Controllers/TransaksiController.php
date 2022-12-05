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
        $totalPendapatan = 0;

        for($i = 0; $i < count($data); $i++) {
            $totalPendapatan += $data[$i]->tarif;
        }

        return response()->json([
            'message' => 'Data Transaksi Sukses Dimuat',
            'data' => $data,
            'jumlahTransaksi' => count($data),
            'totalPendapatan' => $totalPendapatan
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
        
        // check member or not
        if($request->user()->member === 1) {
            $data->tarif = $kendaraan->tarif - ($kendaraan->tarif * 10/100);
        }else {
            $data->tarif = $kendaraan->tarif;
        }
        
        $data->kembalikan = false;
        $data->tgl_sewa = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'message' => 'Data Transaksi Berhasil Ditambahkan',
            'data' => $data
        ], 201);
    }

    public function show(Request $request, $id_transaksi)
    {
        $data = Transaksi::where('id_transaksi', $id_transaksi)->first();

        if($data->id_customer !== $request->user()->id_user) {
            return response()->json(['message' => 'Anda tidak Berhak Atas Transaksi Ini'], 403);
        }
        
        if($data) {
            return response()->json(['data' => $data], 200);
        }else {
            return ['message' => 'Data Transaksi tidak Ditemukan'];
        }
    }

    public function update(Request $request, $id_transaksi) {
        $data = Transaksi::where('id_transaksi', $id_transaksi)->first();

        if($request->user()->id_user !== $data->id_customer) {
            return response()->json(['message' => 'Anda tidak Berhak Atas Transaksi Ini'], 403);
        }

        $data->kembalikan = true;
        $data->tgl_pengembalian = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'message' => 'Berhasil Melakukan Pengembalian Kendaraan Rental',
            'data' => $data
        ], 200);
    }
}
