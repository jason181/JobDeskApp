<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\SubDivisiProyekTransformers;
use App\Sub_Divisi_Proyek;
use App\Transformers\ItemPekerjaanTransformers;
use App\Item_Pekerjaan;


class SubDivisiProyekController extends RestController
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
            $sub_divisi = Sub_Divisi_Proyek::create([
                'Id_Divisi_Proyek'  => $request->Id_Divisi_Proyek,
                'Tanggal_Selesai'   => $request->Tanggal_Selesai,
                'Nama'              => $request->Nama,
                'Persentase'        => $request->Persentase
            ]);
    
            return response()->json([
                'status' => (bool) $sub_divisi,
                'data' => $sub_divisi,
                'message' => $sub_divisi ? 'Success' : 'Error Sub Divisi Proyek'
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
            $sub_divisi = Sub_Divisi_Proyek::find($id);
            return response()->json($sub_divisi,200);
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
            $events = Sub_Divisi_Proyek::find($id)->update($request->All());
            $data = Sub_Divisi_Proyek::find($id);
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
            $sub_divisi = Sub_Divisi_Proyek::find($id);
            $status = $sub_divisi->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function hitungPersentaseSubDivisi($id)
    {
        try {
            $items=Item_Pekerjaan::where('Id_Sub_Divisi_Proyek',$id)->get();
            $counter=0;
            if($items==NULL)
                return 0;
            else{
                foreach($items as $item)
                {
                    $counter+=app('App\Http\Controllers\ItemPekerjaanController')->hitungPersentaseItem($item->Id_Item_Pekerjaan)*$item->Persentase/100;
                }
                return $counter;
            }
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
