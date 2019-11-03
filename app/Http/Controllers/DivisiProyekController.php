<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\DivisiProyekTransformers;
use App\Divisi_Proyek;
use App\Transformers\SubDivisiProyekTransformers;
use App\Sub_Divisi_Proyek;
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
        try{
            $divisi = Divisi_Proyek::create([
                'Id_Divisi_Role'    => $request->Id_Divisi_Role,
                'Id_Proyek'         => $request->Id_Proyek,
                'Tanggal_Selesai'   => $request->Tanggal_Selesai,
                'Persentase'        => $request->Persentase
            ]);
    
            return response()->json([
                'status' => (bool) $divisi,
                'data' => $divisi,
                'message' => $divisi ? 'Success' : 'Error Divisi Proyek'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {   
        try{

            $events = Divisi_Proyek::find($id)->update($request->All());
            $data = Divisi_Proyek::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try{
            $divisi = Divisi_Proyek::find($id);
            return response()->json($divisi,200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $divisi = Divisi_Proyek::find($id);
            $status = $divisi->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function hitungPersentaseDivisi($id)
    {
        try {
            $sub_divisis=Sub_Divisi_Proyek::where('Id_Divisi_Proyek',$id)->get();
            $counter=0;
            foreach($sub_divisis as $sub_divisi)
            {
                $counter+=app('App\Http\Controllers\SubDivisiProyekController')->hitungPersentaseSubDivisi($sub_divisi->Id_Sub_Divisi_Proyek)*$sub_divisi->Persentase/100;
            }
            return $counter;
            
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
