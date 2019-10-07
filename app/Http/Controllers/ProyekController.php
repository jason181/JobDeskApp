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
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $proyek = Proyek::create([
            'Kode'          => $request->Kode,
            'Nama'          => $request->Nama,
            'Pemilik'       => $request->Pemilik,
            'Alamat'        => $request->Alamat,
            'Nilai'         => $request->Nilai,
            'Target_Outcome'=> date('Y-m-d', strtotime($request->Target_Outcome)),
            'Tanggal_Mulai' => date('Y-m-d', strtotime($request->Tanggal_Mulai)),
            'Tanggal_Selesai'=>date('Y-m-d', strtotime($request->Tanggal_Selesai)),
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
        // return $request;
        try{

            $events = Proyek::find($id)->update($request->All());
            $data = Proyek::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function show($id)
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
