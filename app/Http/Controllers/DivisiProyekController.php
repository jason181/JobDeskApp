<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\DivisiProyekTransformers;
use App\Divisi_Proyek;
use App\Transformers\SubDivisiProyekTransformers;
use App\Sub_Divisi_Proyek;

class DivisiProyekController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi=Divisi_Proyek::get();
        $response=$this->generateCollection($divisi);
        return $this->sendResponse($response,201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $divisi = Divisi_Proyek::create([
                'Id_Divisi_Role'    => $request->Id_Divisi_Role,
                'Id_Proyek'         => $request->Id_Proyek,
                'Nama'              => $request->Nama,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $divisi = Divisi_Proyek::find($id);
            return response()->json($divisi,200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
