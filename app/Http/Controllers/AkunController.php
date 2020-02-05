<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
// use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

use App\Transformers\AkunTransformers;
use App\Transformers\LogPengerjaanTransformers;
use App\Transformers\SubItemPekerjaanTransformers;
use App\Transformers\ItemPekerjaanTransformers;
use App\Transformers\SubDivisiProyekTransformers;
use App\Transformers\DivisiProjectTransformers;
use App\Transformers\ProyekTransformers;
use App\Transformers\AksesPekerjaanTransformers;
use App\Transformers\DashboardTransformers;

use App\Akun;
use App\Log_Pengerjaan;
use App\Sub_Item_Pekerjaan;
use App\Item_Pekerjaan;
use App\Sub_Divisi_Proyek;
use App\Divisi_Proyek;
use App\Proyek;
use App\Akses_Pekerjaan;

use Carbon\Carbon;

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
        // return $request;
        try {
            $akun = Akun::find($id);
            // return $akun;
            $Password = $akun->Password;
            // return $Password;
            $Old_Password = bcrypt($request->Old_Password);
            // return $Old_Password;
            $request->Password = bcrypt($request->Password);
            
            if($Password == $Old_Password)
            {
                $akun->Password = $request->Password;
                $akun->save();
                $data = Akun::find($id);
                return $data;
                $response = $this->generateItem($data);
                return $this->sendResponse($response, 201);
            }
            else
            {
                $Pass[0]=$Password;
                $Pass[1]=$Old_Password;
                $Pass[2]=$request->Old_Password;
                return $Pass;
                return false;
            }
            

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

    // private function getFractalManager()
    // {
    //     $request = app(Request::class);
    //     $manager = new Manager();
    //     $manager->setSerializer(new JsonApiSerializer());
    //     if (!empty($request->query('include'))) {
    //         $manager->parseIncludes($request->query('include'));
    //     }
    //     return $manager;
    // }

    // public function getProject($id)
    // {
    //     $accesses=Akses_Pekerjaan::where('Id_Akun',$id)->get();
        
    //     $manager = $this->getFractalManager();
    //     $resource = $this->generateCollection($accesses, new DashboardTransformers);
    //     // return $this->sendResponse($resource,201);
    //     $result = $manager->createData($resource)->toArray();
    //     $result['data'][0]['attributes']['progress']=10;
    //     return $result;
    //     // $results=$this->generateCollection($accesses, new DashboardTransformers);
    //     // foreach($results as $result)
    //     // {
    //         // $log = Log_Pengerjaan::where('Id_Sub_Item_Pekerjaan',$result->id_subtask)->get();
    //         // return $log;
    //     // }
    //     // return $this->sendResponse($results,201);
    // }
    public function getProject($id)
    {
        $accesses=Akses_Pekerjaan::where('Id_Akun',$id)->where('Verifikasi','Verified')->groupBy('Id_Sub_Item_Pekerjaan')->get();
        $results= $this->generateCollection($accesses, new DashboardTransformers);
        $datas  =$this->manager->createData($results)->toArray();
        $datas=array_unique($datas);
        $count=0;
        
        foreach($datas['data'] as $data)
        {
            $alllogs = Log_Pengerjaan::where('Id_Sub_Item_Pekerjaan',$data['Id_Sub_Item_Pekerjaan'])->orderBy('Id_Pengerjaan','desc')->get();
            
            $logs = $alllogs[0];
            
            if ($logs['Berkas']=='')
            {
                foreach($alllogs as $log)
                {
                    if($log['Berkas']!='')
                    {
                        
                        $datas['data'][$count]['Progress']=$log['Progress'];
                        break;
                    }
                    // return $log;
                }
            }
            else
            {
                $datas['data'][$count]['Progress']=$logs['Progress'];
            }
            // return $datas['data'][$count]['Progress'];
            $User=Akun::find($logs['Id_Akun']);
            
            $datas['data'][$count]['User']=$User->Username;
            $now=Carbon::now('Asia/Jakarta');
            // return $now;

            $diff = $now->diffInDays($data['Tanggal_Selesai'], false);
            $remaining = $diff.' days left';

            $datas['data'][$count]['Remaining']=$remaining;

            if ($logs['Progress']==100)
                $datas['data'][$count]['Status']='complete';
            else if($diff<0)
                $datas['data'][$count]['Status']='overdue';
            else
                $datas['data'][$count]['Status']='ongoing';
            $count++;
        }
        return $datas;
    }
}
