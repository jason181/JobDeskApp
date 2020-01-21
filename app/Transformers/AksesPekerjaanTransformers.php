<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Akses_Pekerjaan;

class AksesPekerjaanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Akses_Pekerjaan $akses_pekerjaan)
    {
        return [
            'Id_Akses_Pekerjaan'    => $akses_pekerjaan->Id_Akses_Pekerjaan,
            'Id_Project'            => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->proyeks->Id_Proyek,
            'Id_Divisi_Project'     => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->Id_Divisi_Proyek,
            'Id_Sub_Divisi_Project' => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->Id_Sub_Divisi_Proyek,
            'Id_Item_Pekerjaan'     => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->Id_Item_Pekerjaan,
            'Id_Sub_Item_Pekerjaan' => $akses_pekerjaan->Id_Sub_Item_Pekerjaan,
            'Project'               => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->proyeks->Nama,
            'Divisi'                => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->Nama,
            'Sub_Divisi'            => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->Nama,
            'Task'                  => $akses_pekerjaan->sub_item_pekerjaans->item_pekerjaans->Nama,
            'Sub_Task'              => $akses_pekerjaan->sub_item_pekerjaans->Nama,
            'Id_Akun'               => $akses_pekerjaan->Id_Akun,
            'Username'              => $akses_pekerjaan->akuns->Username,
            'Nama_Pegawai'          => $akses_pekerjaan->akuns->karyawans->Nama,
            'Status'                => $akses_pekerjaan->Status,
            'Deskripsi'             => $akses_pekerjaan->Deskripsi,
            'Verifikasi'            => $akses_pekerjaan->Verifikasi,
            'Datetime_Request'       => date('m-d-Y H:i:s', strtotime($akses_pekerjaan->created_at)),
        ];
    }
}