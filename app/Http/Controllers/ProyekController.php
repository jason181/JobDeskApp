<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ProyekTransformers;
use App\Proyek;

class ProyekController extends RestController
{
    protected $transformer=ProyekTransformers::Class;

    public function index()
    {
        $proyek=Proyek::get();
        $response=$this->generateCollection($proyek);
        return $this->sendResponse($proyek,201);
    }

    public function store(Request $request)
    {
        $proyek = Proyek::create([
            'Kode'          => $request->Kode,
            'Nama'          => $request->Nama,
            'Pemilik'       => $request->Pemilik,
            'Alamat'        => $request->Alamat,
            'Nilai'         => $request->Nilai,
            'Target_Outcome'=> $request->Target_Outcome,
            'Tanggal_Mulai' => $request->Tanggal_Mulai,
            'Tanggal_Selesai'=>$request->Tanggal_Selesai,
            'Catatan'       => $request->Catatan
        ]);

        return response()->json([
            'status' => (bool) $proyek,
            'data' => $proyek,
            'message' => $proyek ? 'Success' : 'Error Proyek'
        ]);
    }

    public function update(Request $request, $id)
    {   
        $proyek = Proyek::find($id);

        if(!is_null($request->Kode)){
            $proyek->Kode = $request->Kode;
        }
        if(!is_null($request->Nama)){
            $proyek->Nama = $request->Nama;
        }
        if(!is_null($request->Pemilik)){
            $proyek->Pemilik = $request->Pemilik;
        }
        if(!is_null($request->Alamat)){
            $proyek->Alamat = $request->Alamat;
        }
        if(!is_null($request->Nilai)){
            $proyek->Nilai = $request->Nilai;
        }
        if(!is_null($request->Target_Outcome)){
            $proyek->Target_Outcome = $request->Target_Outcome;
        }
        if(!is_null($request->Tanggal_Mulai)){
            $proyek->Tanggal_Mulai = $request->Tanggal_Mulai;
        }
        if(!is_null($request->Tanggal_Selesai)){
            $proyek->Tanggal_Selesai = $request->Tanggal_Selesai;
        }
        if(!is_null($request->Catatan)){
            $proyek->Catatan = $request->Catatan;
        }
        

        $success = $proyek->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function showbyID($id)
    {
        $proyek = Proyek::find($id);
        return response()->json($proyek,200);
    }

    public function destroy($id)
    {
        $proyek = Proyek::find($id);
        $status = $proyek->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
