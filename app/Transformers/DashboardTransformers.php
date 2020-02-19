<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Akses_Pekerjaan;

class DashboardTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Akses_Pekerjaan $dashboard)
    {
        return [
            'Id_Akses_Pekerjaan'    => $dashboard->Id_Akses_Pekerjaan,
            'Id_Sub_Item_Pekerjaan' => $dashboard->sub_item_pekerjaans->Id_Sub_Item_Pekerjaan,
            'Id_Proyek'             => $dashboard->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->proyeks->Id_Proyek,
            'Nama_Proyek'           => $dashboard->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->proyeks->Nama,
            'Divisi'                => $dashboard->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->Nama,
            'Sub_Divisi'            => $dashboard->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->Nama,
            'Task'                  => $dashboard->sub_item_pekerjaans->item_pekerjaans->Nama,
            'Sub_Task'              => $dashboard->sub_item_pekerjaans->Nama,
            'Deskripsi_Sub_Task'    => $dashboard->sub_item_pekerjaans->Deskripsi,
            'Due'                   => date('m-d-Y', strtotime($dashboard->sub_item_pekerjaans->Tanggal_Selesai)),
            'Total_Progress'        => 0,
            'Progress'              => 0,
            'Desc'                  => $dashboard->sub_item_pekerjaans->Deskripsi,
            'Remaining'             => '',
            'Status_Progress'       => '',
            'Tanggal_Selesai'       => $dashboard->sub_item_pekerjaans->Tanggal_Selesai,
            'Verifikasi'            => $dashboard->Verifikasi,
            'Datetime_Request'      => date('m-d-Y H:i:s', strtotime($dashboard->created_at)),
            'Status_Akses_Pekerjaan'=> $dashboard->Status,
            'Id_Akun'               => $dashboard->Id_Akun,
            'Username'              => $dashboard->akuns->Username,
            'Nama_Pegawai'          => $dashboard->akuns->karyawans->Nama,
            'Deskripsi'             => $dashboard->Deskripsi,
            'User'                  => '',
        ];
    }
}