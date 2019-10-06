<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\KaryawanTransformers;
use App\Karyawan;

class KaryawanController extends RestController
{
    protected $transformer=KaryawanTransformers::Class;

    public function index()
    {
        $karyawan=Karyawan::get();
        $response=$this->generateCollection($karyawan);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        
        $karyawan = Karyawan::create([
            'Id_Divisi_Role'=> $request->Id_Divisi_Role,
            'Id_Jabatan'    => $request->Id_Jabatan,
            'Kode'          => $request->Kode,
            'Nama'          => $request->Nama,
            'Alamat'        => $request->Alamat,
            'Telepon'       => $request->Telepon,
            'Tanggal_Masuk' => $request->Tanggal_Masuk,
            'Grade'         => $request->Grade,
            'KTP'           => $request->KTP,
            'Nomor_Asosiasi'=> $request->Nomor_Asosiasi,
            'Nomor_SKA'     => $request->Nomor_SKA
        ]);

        return response()->json([
            'status' => (bool) $karyawan,
            'data' => $karyawan,
            'message' => $karyawan ? 'Success' : 'Error Karyawan'
        ]);
    }

    public function update(Request $request, $id)
    {   
        $karyawan = Karyawan::find($id);

        if(!is_null($request->Id_Divisi_Role)){
            $karyawan->Id_Divisi_Role = $request->Id_Divisi_Role;
        }
        if(!is_null($request->Id_Jabatan)){
            $karyawan->Id_Jabatan = $request->Id_Jabatan;
        }
        if(!is_null($request->Kode)){
            $karyawan->Kode = $request->Kode;
        }
        if(!is_null($request->Nama)){
            $karyawan->Nama = $request->Nama;
        }
        if(!is_null($request->Alamat)){
            $karyawan->Alamat = $request->Alamat;
        }
        if(!is_null($request->Telepon)){
            $karyawan->Telepon = $request->Telepon;
        }
        if(!is_null($request->Tanggal_Masuk)){
            $karyawan->Tanggal_Masuk = $request->Tanggal_Masuk;
        }
        if(!is_null($request->Grade)){
            $karyawan->Grade = $request->Grade;
        }
        if(!is_null($request->KTP)){
            $karyawan->KTP = $request->KTP;
        }
        if(!is_null($request->Nomor_Asosiasi)){
            $karyawan->Nomor_Asosiasi = $request->Nomor_Asosiasi;
        }
        if(!is_null($request->Nomor_SKA)){
            $karyawan->Nomor_SKA = $request->Nomor_SKA;
        }

        $success = $karyawan->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function updateSimple(Request $request,$id)  {
        try{

            $events = Karyawan::find($id)->update($request->All());
            $data = Karyawan::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);


        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function showbyID($id)
    {
        $karyawan = Karyawan::find($id);
        return response()->json($karyawan,200);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        $status = $karyawan->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
