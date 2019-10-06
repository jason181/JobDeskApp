<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\DivisiProyekTransformers;
use App\Divisi_Proyek;

class DivisiProyekController extends RestController
{
    protected $transformer=DivisiProyekTransformers::Class;

    public function index()
    {
        $divisi=Divisi_Proyek::get();
        $response=$this->generateCollection($divisi);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        $divisi = Divisi_Proyek::create([
            'Id_Divisi_Role'    => $request->Id_Divisi_Role,
            'Id_Proyek'         => $request->Id_Proyek,
            'Tanggal_Selesai'   => $request->Tanggal_Selesai,
            'Persentase'        => $request->Persentase
        ]);

        return response()->json([
            'status' => (bool) $divisi,
            'data' => $divisi,
            'message' => $divisi ? 'Success' : 'Error Divisi'
        ]);
    }

    public function update(Request $request, $id)
    {   
        $divisi = Divisi_Proyek::find($id);

        if(!is_null($request->Id_Divisi_Role)){
            $divisi->Id_Divisi_Role = $request->Id_Divisi_Role;
        }
        if(!is_null($request->Id_Proyek)){
            $divisi->Id_Proyek = $request->Id_Proyek;
        }
        if(!is_null($request->Tanggal_Selesai)){
            $divisi->Tanggal_Selesai = $request->Tanggal_Selesai;
        }
        if(!is_null($request->Persentase)){
            $divisi->Persentase = $request->Persentase;
        }

        $success = $divisi->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function showbyID($id)
    {
        $divisi = Divisi_Proyek::find($id);
        return response()->json($divisi,200);
    }

    public function destroy($id)
    {
        $divisi = Divisi_Proyek::find($id);
        $status = $divisi->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
