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
    }

    public function update(Request $request, $id)
    {   
        $item = Item_Pekerjaan::find($id);


        if(!is_null($request->Id_Proyek)){
            $item->Id_Proyek = $request->Id_Proyek;
        }
        if(!is_null($request->Id_Divisi_Role)){
            $item->Id_Divisi_Role = $request->Id_Divisi_Role;
        }
        if(!is_null($request->Nama)){
            $item->Nama = $request->Nama;
        }
        if(!is_null($request->Kode)){
            $item->Kode = $request->Kode;
        }
        if(!is_null($request->Satuan)){
            $item->Satuan = $request->Satuan;
        }
        if(!is_null($request->Tanggal_Selesai)){
            $item->Tanggal_Selesai = $request->Tanggal_Selesai;
        }
        if(!is_null($request->Persentase)){
            $item->Persentase = $request->Persentase;
        }

        $success = $item->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function showbyID($id)
    {
        $item = Item_Pekerjaan::find($id);
        return response()->json($item,200);
    }

    public function destroy($id)
    {
        $item = Item_Pekerjaan::find($id);
        $status = $item->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
