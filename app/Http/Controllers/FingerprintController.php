<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\FingerprintTransformers;

use App\Fingerprint_Machine as FP;

class FingerprintController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $transformer=FingerprintTransformers::Class;

    public function index()
    {
        $fp = FP::orderBy('IP')->paginate(10);
        $response=$this->generateCollection($fp);
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
            $fp = FP::create([
                'IP'    => $request->IP,
                'Comkey'=> $request->Comkey,
                'Status'=> $request->Status,
             ]);
             return response()->json([
                'status' => (bool) $fp,
                'data' => $fp,
                'message' => $fp ? 'Success' : 'Error Fingerprint'
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
        try{

            $events = FP::find($id)->update($request->All());
            $data = FP::find($id);
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
            $fp = FP::find($id);
            $status = $divisi->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
        FP::find($id)->delete();
    }

    public function check_connection($id)
    {
        $mesin = FP::find($id);
        $IP = $mesin->IP;
        // $port = $mesin->port;

        $connect = @fsockopen($IP, '80', $errno, $errstr, 1);
        // $connect = @fsockopen($IP, $port, $errno, $errstr, 1);
        return response()->json([
            'status' => $connect,
            'message' => $connect ? 'Connected' : 'Not Connected'
        ]);

        // if ($connect) {
        //     return "Mesin terkoneksi! <br> <a href='" . route('fingerprint_index') . "'>Kembali</a>";
        // } else {
        //     return "Mesin tidak terkoneksi! <br> <a href='" . route('fingerprint_index') . "'>Kembali</a>";
        // }
    }

    public function active($id)
    {
      $mesin = FP::find($id);
      $mesin->status = 1;
      $mesin->save();
      $response = $this->generateItem($mesin);
      return $this->sendResponse($response,201);
    //   return redirect()->route('fingerprint_index');
    }

    public function deactive($id)
    {
      $mesin = FP::find($id);
      $mesin->status = 0;
      $mesin->save();
      $response = $this->generateItem($mesin);
      return $this->sendResponse($response,201);

    //   return redirect()->route('fingerprint_index');
    }
}
