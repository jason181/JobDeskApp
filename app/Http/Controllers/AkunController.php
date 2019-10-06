<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AkunTransformers;
use App\Akun;

class AkunController extends Controller
{
    protected $transformer=AkunTransformers::Class;

    public function index()
    {
        $akun=Akun::get();
        $response=$this->generateCollection($akun);
        return $this->sendResponse($akun,201);
    }

    public function update(Request $request, $username)
    {   
        $akun = Akun::where('Username',$username)->first();

        if(!is_null($request->Password)){
            $akun->Password = $request->Password;
        }

        $success = $akun->save();
        if(!$success){
            return response()->json('Error Update',500);
        }else   
            return response()->json('Success',200);
    }

    public function showbyID($id)
    {
        $akun = Akun::find($id);
        return response()->json($akun,200);
    }

    public function destroy($id)
    {
        $akun = Akun::find($id);
        $status = $akun->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }    
}
