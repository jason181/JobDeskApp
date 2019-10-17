<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akses;
use App\Transformers\AksesTransformers;

class AksesController extends RestController
{
    protected $transformer=AksesTransformers::Class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akses=Akses::get();
        $response=$this->generateCollection($akses);
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
            $akses = Akses::create([
                'Id_Karyawan'   => $request->Id_Karyawan,
                'Fitur'         => $request->Fitur
            ]);
    
            return response()->json([
                'status' => (bool) $akses,
                'data' => $akses,
                'message' => $akses ? 'Success' : 'Error Akses'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Akses  $akses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $akses = Akses::find($id);
            $response = $this->generateItem($akses);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Akses  $akses
     * @return \Illuminate\Http\Response
     */
    public function edit(Akses $akses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Akses  $akses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $events = Akses::find($id)->update($request->All());
            $data = Akses::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);
        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Akses  $akses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
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
