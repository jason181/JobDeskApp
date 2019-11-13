<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AksesPekerjaanTransformers;
use App\Akses_Pekerjaan;

class AksesPekerjaanController extends RestController
{
    protected $transformer = AksesPekerjaanTransformers::Class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $akses_pekerjaan=Akses_Pekerjaan::orderBy('Id_Akses_Pekerjaan', 'DESC')->get();
        $akses_pekerjaan=Akses_Pekerjaan::get();
        $response=$this->generateCollection($akses_pekerjaan);
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
            $akses_pekerjaan = Akses_Pekerjaan::create([
                'Id_Sub_Item_Pekerjaan' => $request->Id_Sub_Item_Pekerjaan,
                'Id_Akun'               => $request->Id_Akun,
                'Status'                => $request->Status,
                'Verifikasi'            => $request->Verifikasi
            ]);
    
            return response()->json([
                'status' => (bool) $akses_pekerjaan,
                'data' => $akses_pekerjaan,
                'message' => $akses_pekerjaan ? 'Success' : 'Error Akses Pekerjaan'
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
            $akses_pekerjaan = Akses_Pekerjaan::find($id);
            return response()->json($akses_pekerjaan,200);
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
            $events = Akses_Pekerjaan::find($id)->update($request->All());
            $data = Akses_Pekerjaan::find($id);
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
            $akses_pekerjaan = Akses_Pekerjaan::find($id);
            $status = $akses_pekerjaan->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
