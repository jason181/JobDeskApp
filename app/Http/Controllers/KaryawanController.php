<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Transformers\KaryawanTransformers;
use Illuminate\Support\Facades\DB;

use App\Karyawan;

use App\Transformers\AkunTransformers;
use App\Akun;

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
        try {
            $Akses = $request->get('Akses');

            $akun = Akun::create([
                'Username'  => $request->Username,
                'Password'  => bcrypt($request->Username),
            ]);

            $karyawan = Karyawan::create([
                'Id_Divisi_Role'=> $request->Id_Divisi_Role,
                'Id_Jabatan'    => $request->Id_Jabatan,
                'Id_Akun'       => $akun->Id_Akun,
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
            if($request->has('Akses'))
            {
                $karyawan = DB::transaction(function () use ($karyawan,$Akses) {
                    $karyawan->akses()->createMany($Akses);
                    return $karyawan;
                });
            }

            return response()->json([
                'status' => (bool) $karyawan,
                'data' => $karyawan,
                'message' => $karyawan ? 'Success' : 'Error Karyawan'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
    
    public function update(Request $request,$id)  {
        try{
            $events = Karyawan::find($id)->update($request->All());
            $data = Karyawan::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $karyawan = Karyawan::find($id);
            return response()->json($karyawan,200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::find($id);
            $status = $karyawan->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
