<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class KendaraanController extends Controller
{
    public function index()
    {
        $data = Kendaraan::all();

        return response()->json([
            'message' => 'Data Kendaraan Sukses Dimuat',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = new Kendaraan();
        $data->id_kendaraan = Uuid::uuid4()->toString();
        $data->nomor_polisi = $request->nomor_polisi;
        $data->jenis_kendaraan = $request->jenis_kendaraan;
        $data->merk = $request->merk;
        $data->tarif = $request->tarif;
        $data->kapasitas = $request->kapasitas;
        $data->created_at = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'message' => 'Data Kendaraan Berhasil Disimpan',
            'data' => $data
        ], 201);
    }

    public function show($id_kendaraan)
    {
        $data = Kendaraan::where('id_kendaraan', $id_kendaraan)->first();
        if($data) {
            return $data;
        }else {
            return ['message' => 'Data Kendaraan tidak Ditemukan'];
        }
    }

    public function update(Request $request, $id_kendaraan)
    {
        $data = Kendaraan::where('id_kendaraan', $id_kendaraan)->first();
        if($data) {
            $data->nomor_polisi = $request->nomor_polisi ? $request->nomor_polisi : $data->nomor_polisi;
            $data->jenis_kendaraan = $request->jenis_kendaraan ? $request->jenis_kendaraan : $data->jenis_kendaraan;
            $data->merk = $request->merk ? $request->merk : $data->merk;
            $data->tarif = $request->tarif ? $request->tarif : $data->tarif;
            $data->kapasitas = $request->kapasitas ? $request->kapasitas : $data->kapasitas;
            $data->update_at = date('Y-m-d H:i:s');
            $data->save();

            return $data;
        }else {
            return ['message' => 'Data Kendaraan tidak Ditemukan'];
        }
    }

    public function destroy($id_kendaraan)
    {
        $data = Kendaraan::where('id_kendaraan', $id_kendaraan)->first();
        if($data) {
            $data->delete();
            return ['message' => 'Data Kendaraan Berhasil Dihapus'];
        }else {
            return ['message' => 'Data Kendaraan tidak Ditemukan'];
        }
    }
}
