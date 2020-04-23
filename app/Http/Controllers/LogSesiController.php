<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\LogSesiTransformers;
use App\Log_Sesi;
use App\Akun;
use Carbon\Carbon;

class LogSesiController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $transformer=LogSesiTransformers::Class;

    public function index()
    {
        $log_sesi=Log_Sesi::get();
        $response=$this->generateCollection($log_sesi);
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
            // $waktu = Carbon::now('Asia/Jakarta')->isoFormat('DD-MM-YYYY');
            // return $waktu;
            $waktu = Carbon::now('Asia/Jakarta');
            $akun = Akun::where('Username',$request->Username)->first();
            $log_sesi = Log_Sesi::create([
                'Id_Akun'   => $akun->Id_Akun,
                'Waktu'     => $waktu,
                'Keterangan'=> $request->Keterangan
            ]);
    
            return response()->json([
                'status' => (bool) $log_sesi,
                'data' => $log_sesi,
                'message' => $log_sesi ? 'Success' : 'Error Log Sesi'
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
            $log_sesi = Log_Sesi::find($id);
            return response()->json($log_sesi,200);
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
            $events = Log_Sesi::find($id)->update($request->All());
            $data = Log_Sesi::find($id);
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
            $log_sesi = Log_Sesi::find($id);
            $status = $log_sesi->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
