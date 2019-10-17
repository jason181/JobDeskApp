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
    }
    
    public function update(Request $request,$id)  {
        try{
            $Akses = $request->get('Akses');
            $events = Karyawan::find($id)->update($request->All());
            $data = Karyawan::find($id);
            if($request->has('Akses'))
            {
                $data->akses()->delete();
            }
            if($request->has('Akses'))
            {
                $data = DB::transaction(function () use ($data,$Akses) {
                    $data->akses()->createMany($Akses);
                    return $data;
                });
            }
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
        $karyawan->akses()->delete();
        $status = $karyawan->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
