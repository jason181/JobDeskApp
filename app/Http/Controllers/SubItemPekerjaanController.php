<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\SubItemPekerjaanTransformers;
use App\Sub_Item_Pekerjaan;
use App\Transformers\LogPengerjaanTransformers;
use App\Log_Pengerjaan;

class SubItemPekerjaanController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_divisi=Sub_Divisi_Proyek::get();
        $response=$this->generateCollection($sub_divisi);
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
            $sub_item = Sub_Item_Proyek::create([
                'Id_Item_Pekerjaan' => $request->Id_Divisi_Role,
                'Nama'              => $request->Nama,
                'Kode'              => $request->Kode,
                'Tanggal_Selesai'   => $request->Tanggal_Selesai,
                'Persentase'        => $request->Persentase
            ]);
    
            return response()->json([
                'status' => (bool) $sub_item,
                'data' => $sub_item,
                'message' => $sub_item ? 'Success' : 'Error Sub Item Pekerjaan'
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
            $sub_item = Sub_Item_Pekerjaan::find($id);
            return response()->json($sub_item,200);
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
            $events = Sub_Item_Pekerjaan::find($id)->update($request->All());
            $data = Sub_Item_Pekerjaan::find($id);
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
            $sub_item = Sub_Item_Pekerjaan::find($id);
            $status = $sub_item->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
    
    public function hitungPersentaseSubItem($id)
    {
        try {
            $log_pengerjaan = Log_Pengerjaan::where('Id_Sub_Item_Pekerjaan',$id)->orderBy('Id_Pengerjaan','desc')->first();
            return $log_pengerjaan->Progress;
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
