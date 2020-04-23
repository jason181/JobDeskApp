<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Token;
use App\Akun;
use App\Log_Sesi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\InvalidTokenException;
use App\Transformers\TokenTransformers;
use App\Transformers\UserTransformer;
use App\Exceptions\InvalidCredentialException;
use Hash;
use App\Events\TokenRefresh;

class TokenController extends RestController
{
    protected $transformer = TokenTransformers::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));
            $now = Carbon::now();
            $token = new Token;
            $token->Id_Akun=$user->Id_Akun;
            $token->Username=str_random(32);
            $token->Password=str_random(32);
            $token->save();
            
            // $log_sesi = Log_Sesi::create([
            //     'Id_Akun'   => $user->Id_Akun,
            //     'Waktu'     => $now,
            //     'Keterangan'=> "Login"
            // ]);

            $response = $this->generateItem($token);
            return $this->sendResponse($response, 201);
        } catch (InvalidCredentialExcpetion $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function validateUser($username,$password)
    {
        try{
            $user = Akun::where('Username',$username)->firstOrFail();
            
            if (!password_verify($password, $user->Password)) {
                throw new InvalidCredentialException();
            }

            return $user;
        } catch(ModelNotFoundException $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function validateToken(Request $request)
    {
        try {
            $header = $request->header('Authorization');
            list($type, $payload) = explode(" ", $header);
            list($username, $password) = explode(":", base64_decode($payload));
            $token = Token::where('Username', $username)->first();
            $akun = Akun::find($token->Id_Akun);
            event(new TokenRefresh($token));
            $item = $this->generateItem($akun,'App\Transformers\AkunTransformers');
            return $this->sendResponse($item);
        } catch (\Exception $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (InvalidTokenException $e) {
            throw $e;
        }
    }
    public function index()
    {
        $tokens = Token::all();
        $response = $this->generateCollection($tokens);
        return $this->sendResponse($response);
    }
}