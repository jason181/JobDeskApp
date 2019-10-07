<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\DivisiRoleTransformers;
use App\Divisi_Role;

class DivisiRoleController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $transformer=DivisiRoleTransformers::Class;

    public function index()
    {
        $divisi=Divisi_Role::get();
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
        $divisi = Divisi_Role::create([
            'Kode'      => $request->Kode,
            'Deskripsi' => $request->Deskripsi
        ]);

        return response()->json([
            'status' => (bool) $divisi,
            'data' => $divisi,
            'message' => $divisi ? 'Success' : 'Error Divisi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $divisi = Divisi_Role::find($id);
        return response()->json($divisi,200);
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

            $events = Divisi_Role::find($id)->update($request->All());
            $data = Divisi_Role::find($id);
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
        $divisi = Divisi_Role::find($id);
        $status = $divisi->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }
}
