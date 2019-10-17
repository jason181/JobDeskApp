<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AkunTransformers;
use App\Akun;

class AkunController extends RestController
{
    protected $transformer=AkunTransformers::Class;

    public function index()
    {
        $akun=Akun::get();
        $response=$this->generateCollection($akun);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        try {
            $akun = Akun::create([
                'Username'  => $request->Username,
                'Password'  => $request->Password
            ]);
    
            return response()->json([
                'status' => (bool) $akun,
                'data' => $akun,
                'message' => $akun ? 'Success' : 'Error Akun'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
        
    }

    public function update(Request $request, $id)
    {   
        try {
            $events = Akun::find($id)->update($request->All());
            $data = Akun::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {

            $akun = Akun::find($id);
            $response=$this->generateItem($akun);
            return $this->sendResponse($response,201);
        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $akun = Akun::find($id);
            $status = $akun->delete();
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Deleted' : 'Error Delete'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
