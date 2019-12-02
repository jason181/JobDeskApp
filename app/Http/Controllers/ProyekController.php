<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Transformers\ProyekTransformers;
use App\Proyek;
use App\Transformers\DivisiProyekTransformers;
use App\Divisi_Proyek;
use App\Sub_Divisi_Proyek;
use App\Item_Pekerjaan;
use App\Sub_Item_Pekerjaan;

class ProyekController extends RestController
{
    protected $transformer=ProyekTransformers::Class;

    public function index()
    {
        $proyek=Proyek::get();
        $response=$this->generateCollection($proyek);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            $proyek = Proyek::create([
                'Kode'          => $request->Kode,
                'Nama'          => $request->Nama,
                'Pemilik'       => $request->Pemilik,
                'Alamat'        => $request->Alamat,
                'Nilai'         => $request->Nilai,
                'Target_Outcome'=> date('Y-m-d', strtotime($request->Target_Outcome)),
                'Tanggal_Mulai' => date('Y-m-d', strtotime($request->Tanggal_Mulai)),
                'Tanggal_Selesai'=>date('Y-m-d', strtotime($request->Tanggal_Selesai)),
                'Catatan'       => $request->Catatan
            ]);
            
            return response()->json([
                'status' => (bool) $proyek,
                'data' => $proyek,
                'message' => $proyek ? 'Success' : 'Error Proyek'
            ]);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeAll(Request $request)
    {
        try {
            if($request->has('All_Divisi'))
            {
                $All_Divisi = $request->get('All_Divisi');
            }
            else{
                return response()->json([
                    'status' => 'All_Divisi Ga masuk',
                ]);
            }
            if($request->has('All_SubDivisi'))
            {
                $All_SubDivisi = $request->get('All_SubDivisi');

            }
            else{
                return response()->json([
                    'status' => 'All_SubDivisi Ga masuk',
                ]);
            }
            if($request->has('All_Task'))
            {
                $All_Task = $request->get('All_Task');
            }
            else{
                return response()->json([
                    'status' => 'All_Task Ga masuk',
                ]);
            }
            if($request->has('All_SubTask'))
            {
                $All_SubTask = $request->get('All_SubTask');
            }
            else{
                return response()->json([
                    'status' => 'All_SubTask Ga masuk',
                ]);
            }

            date_default_timezone_set('Asia/Jakarta');
            $proyek = Proyek::create([
                'Kode'          => $request->Kode,
                'Nama'          => $request->Nama,
                'Pemilik'       => $request->Pemilik,
                'Alamat'        => $request->Alamat,
                'Nilai'         => $request->Nilai,
                'Target_Outcome'=> date('Y-m-d', strtotime($request->Target_Outcome)),
                'Tanggal_Mulai' => date('Y-m-d', strtotime($request->Tanggal_Mulai)),
                'Tanggal_Selesai'=>date('Y-m-d', strtotime($request->Tanggal_Selesai)),
                'Catatan'       => $request->Catatan
            ]);
            
            

            $proyek = DB::transaction(function () use ($proyek,$All_Divisi) {
                $proyek->divisi_proyeks()->createMany($All_Divisi);
                return $proyek;
            });

            $divisi_data= Divisi_Proyek::where('Id_Proyek',$proyek->Id_Proyek)->get();
            // return $divisi_data;

            //Data dari DB yang bersangkutan
            $sub_divisi_data=[];
            $task_data=[];
            $sub_task_data=[];


            foreach($divisi_data as $divisi)
            {
                foreach($All_SubDivisi as $sub_divisi)
                {   
                    if($divisi->Nama == $sub_divisi['Divisi'])
                    {
                        // $getsub = $divisi->sub_divisi_proyeks()->create($sub_divisi);
                        array_push($sub_divisi_data,$divisi->sub_divisi_proyeks()->create($sub_divisi));

                       
                    }
                }
                
            }
            foreach($sub_divisi_data as $sub_divisi)
            {   
                foreach($All_Task as $task)
                {  
                    if($sub_divisi->Nama == $task['Sub_Divisi'])
                    {
                        // $getsub = $divisi->sub_divisi_proyeks()->create($sub_divisi);
                        array_push($task_data,$sub_divisi->item_pekerjaans()->create($task));
                    }
                }
            }
            foreach($task_data as $task)
            {   
                foreach($All_SubTask as $sub_task)
                {  
                    if($task->Nama == $sub_task['Task'])
                    {
                        // $getsub = $divisi->sub_divisi_proyeks()->create($sub_divisi);
                        array_push($sub_task_data,$task->sub_item_pekerjaans()->create($sub_task));
                    }
                }
            }
            
            // return $divisi;
            $response = $this->generateItem($proyek);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {   
        try{

            $events = Proyek::find($id)->update($request->All());
            $data = Proyek::find($id);
            $response = $this->generateItem($data);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateAll(Request $request, $id)
    {   
        try{
            $events = Proyek::find($id)->update($request->All());

            if($request->has('All_Divisi'))
            {
                $All_Divisi = $request->get('All_Divisi');
                foreach($All_Divisi as $divisi)
                {
                    Divisi_Proyek::find($divisi['Id_Divisi_Proyek'])->update($divisi);  
                }
            }

            if($request->has('All_SubDivisi'))
            {
                $All_SubDivisi = $request->get('All_SubDivisi');
                foreach($All_SubDivisi as $sub_divisi)
                {
                    Sub_Divisi_Proyek::find($sub_divisi['Id_Sub_Divisi_Proyek'])->update($sub_divisi);  
                }

            }

            if($request->has('All_Task'))
            {
                $All_Task = $request->get('All_Task');
                foreach($All_Task as $task)
                {
                    Item_Pekerjaan::find($task['Id_Item_Pekerjaan'])->update($task);  
                }
            }

            if($request->has('All_SubTask'))
            {
                $All_SubTask = $request->get('All_SubTask');
                foreach($All_SubTask as $sub_task)
                {
                    Sub_Item_Pekerjaan::find($sub_task['Id_Sub_Item_Pekerjaan'])->update($sub_task);  
                }
            }

            $proyek = Proyek::find($id);
            $response = $this->generateItem($proyek);
            return $this->sendResponse($response, 201);

        }catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $proyek = Proyek::find($id);
        return response()->json($proyek,200);
    }

    public function destroy($id)
    {
        $proyek = Proyek::find($id);
        $status = $proyek->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function hitungPersentaseProyek($id)
    {
        try {
            $divisis=Divisi_Proyek::where('Id_Proyek',$id)->get();
            $counter=0;
            foreach($divisis as $divisi)
            {
                $counter+=app('App\Http\Controllers\DivisiProyekController')->hitungPersentaseDivisi($divisi->Id_Divisi_Proyek)*$divisi->Persentase/100;
            }
            return $counter;
            
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
