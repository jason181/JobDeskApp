<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log_Pengerjaan;
use App\Karyawan;
use App\Akun;

use App\Transformers\LogPengerjaanTransformers;
use App\Transformers\KaryawanTransformers;
use App\Transformers\AkunTransformers;
use Carbon\Carbon;

class LogPengerjaanController extends RestController
{
    protected $transformer=LogPengerjaanTransformers::Class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log=Log_Pengerjaan::get();
        $response=$this->generateCollection($log);
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
            // $now=Carbon::now('Asia/Jakarta')->isoFormat('h:mm');
            $now=Carbon::now('Asia/Jakarta');

            $log = Log_Pengerjaan::create([
                'Id_Sub_Item_Pekerjaan' => $request->Id_Sub_Item_Pekerjaan,
                'Id_Akun'               => $request->Id_Akun,
                'Waktu_Mulai'           => $now,
                'Waktu_Selesai'         => $now,
                'Progress'              => 0,
                'Berkas'                => '',
                'Catatan'               => '',

            ]);
            return response()->json([
                'status' => (bool) $log,
                'data' => $log,
                'message' => $log ? 'Success' : 'Error Log'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeFile(Request $request)
    {
        try {
            
            ini_set('memory_limit','256M');
            $file = $request->file('Berkas');
      
            $nama_file = $file->getClientOriginalName();
            $ukuran_file = $file->getSize();
            $akun = Akun::find($request->Id_Akun);
            $karyawan = $akun->karyawans;
            $destinationPath ="uploads/".$karyawan->Nama."/".Carbon::now('Asia/Jakarta')->isoFormat('DD-MM-YYYY');
            $file->move($destinationPath,$file->getClientOriginalName());
            $path=$destinationPath."/".$nama_file;
            return response()->json([
                'status' => (bool) $path,
                'data' => $path,
                'message' => $path ? 'Success' : 'Error Path'
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
        //
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
        try {
            // return $request;
            // if($request->Progress==100)
                // $waktu_selesai = Carbon::now('Asia/Jakarta')->isoFormat('h:mm');
                $waktu_selesai = Carbon::now('Asia/Jakarta');
                
            // else
            //     $waktu_selesai = NULL;
            // $log = Log_Pengerjaan::find($id);
            $log = Log_Pengerjaan::find($id)->update([
                'Waktu_Selesai'         => $waktu_selesai,
                'Progress'              => $request->Progress,
                'Berkas'                => $request->Berkas,
                'Catatan'               => $request->Catatan,
            ]);
            $data = Log_Pengerjaan::find($id);

            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
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
        //
        try {
            $log = Log_Pengerjaan::find($id);
            $status = $log->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
