<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Transformers\SubItemPekerjaanTransformers;
use App\Sub_Item_Pekerjaan;
use App\Transformers\ItemPekerjaanTransformers;
use App\Item_Pekerjaan;

class ItemPekerjaanController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item=Item_Pekerjaan::get();
        $response=$this->generateCollection($item);
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
        try {
            $item = Item_Pekerjaan::create([
                'Id_Sub_Divisi_Proyek'=> $request->Id_Sub_Divisi_Proyek,
                'Id_Divisi_Role'    => $request->Id_Divisi_Role,
                'Nama'              => $request->Nama,
                // 'Kode'              => $request->Kode,
                // 'Satuan'            => $request->Satuan,
                'Tanggal_Selesai'   => $request->Tanggal_Selesai,
                'Durasi'            => $request->Durasi,
                'Persentase'        => $request->Persentase,
            ]);

            return response()->json([
                'status' => (bool) $item,
                'data' => $item,
                'message' => $item ? 'Success' : 'Error Item Pekerjaan'
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
        try {
            $item = Item_Pekerjaan::find($id);
            return response()->json($item,200);
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
            $events = Item_Pekerjaan::find($id)->update($request->All());
            $data = Item_Pekerjaan::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response,201);

        }catch(\Exception $e) {
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
            $item = Item_Pekerjaan::find($id);
            $status = $item->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
