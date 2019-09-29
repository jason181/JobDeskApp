<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\DivisiTransformers;
use App\Divisi;

class DivisiController extends RestController
{
    protected $transformer=DivisiTransformers::Class;

    public function index()
    {
        $divisi=Divisi::get();
        $response=$this->generateCollection($divisi);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        $divisi = Divisi::create([
            'Kode'      => $request->Kode,
            'Keterangan'=> $request->Keterangan
        ]);

        return response()->json([
            'status' => (bool) $divisi,
            'data' => $divisi,
            'message' => $divisi ? 'Success' : 'Error Divisi'
        ]);
    }

    public function update(Request $request, $id)
    {   
        $divisi = Divisi::find($id);

        if(!is_null($request->Kode)){
            $divisi->Kode = $request->Kode;
        }
        if(!is_null($request->Keterangan)){
            $divisi->Keterangan = $request->Keterangan;
        }

        $success = $divisi->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function showbyID($id)
    {
        $divisi = Divisi::find($id);
        return response()->json($divisi,200);
    }

    public function destroy($id)
    {
        $divisi = Divisi::find($id);
        $status = $divisi->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
