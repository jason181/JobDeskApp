<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemPekerjaanController extends Controller
{
    protected $transformer=ItemPekerjaanTransformers::Class;

    public function index()
    {
        $item=Item_Pekerjaan::get();
        $response=$this->generateCollection($item);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        try {
            $item = Item_Pekerjaan::create([
                'Id_Proyek'         => $request->Id_Proyek,
                'Id_Divisi_Role'    => $request->Id_Divisi_Role,
                'Nama'              => $request->Nama,
                'Kode'              => $request->Kode,
                'Satuan'            => $request->Satuan,
                'Tanggal_Selesai'   => $request->Tanggal_Selesai,
                'Persentase'        => $request->Persentase,
            ]);

            return response()->json([
                'status' => (bool) $item,
                'data' => $item,
                'message' => $item ? 'Success' : 'Error Divisi'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

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

    public function show($id)
    {
        try {
            $item = Item_Pekerjaan::find($id);
            return response()->json($item,200);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

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
