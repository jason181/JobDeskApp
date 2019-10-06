<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\JabatanTransformers;
use App\Jabatan;


class JabatanController extends RestController
{
    protected $transformer=JabatanTransformers::Class;

    public function index()
    {
        $jabatan=Jabatan::get();
        $response=$this->generateCollection($jabatan);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        $jabatan = Jabatan::create([
            'Kode'      => $request->Kode,
            'Deskripsi' => $request->Deskripsi
        ]);

        return response()->json([
            'status' => (bool) $jabatan,
            'data' => $jabatan,
            'message' => $jabatan ? 'Success' : 'Error Jabatan'
        ]);
    }

    public function update(Request $request, $id)
    {   
        // $jabatan = Jabatan::find($id);

        // if(!is_null($request->Kode)){
        //     $jabatan->Kode = $request->Kode;
        // }
        // if(!is_null($request->Keterangan)){
        //     $jabatan->Keterangan = $request->Keterangan;
        // }

        // $success = $jabatan->save();
        // if(!$success){
        //     return response()->json('Error Update',500);
        // }else   
        //     return response()->json('Success',200);
        try{

            $events = Jabatan::find($id)->update($request->All());
            $data = Jabatan::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);


        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function showbyID($id)
    {
        $jabatan = Jabatan::find($id);
        return response()->json($jabatan,200);
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $status = $jabatan->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
