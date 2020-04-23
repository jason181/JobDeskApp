<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Log_Pengerjaan;

class LogPengerjaanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Log_Pengerjaan $log_pengerjaan)
    {
        // transform($data)

        return [
            'Id_Log_Pengerjaan'     => $log_pengerjaan->Id_Pengerjaan,
            'Id_Sub_Item_Pekerjaan' => $log_pengerjaan->Id_Sub_Item_Pekerjaan,
            'Id_Proyek'             => $log_pengerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->proyeks->Id_Proyek,
            'Id_Akun'               => $log_pengerjaan->Id_Akun,
            'Username'              => $log_pengerjaan->akuns->Username,
            'Nama'                  => $log_pengerjaan->akuns->karyawans->Nama,
            'Divisi_Karyawan'       => $log_pengerjaan->akuns->karyawans->divisi_roles->Deskripsi,
            'Divisi'                => $log_pengerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->divisi_proyeks->Nama,
            'Sub_Divisi'            => $log_pengerjaan->sub_item_pekerjaans->item_pekerjaans->sub_divisi_proyeks->Nama,
            'Task'                  => $log_pengerjaan->sub_item_pekerjaans->item_pekerjaans->Nama,
            'Sub_Task'              => $log_pengerjaan->sub_item_pekerjaans->Nama,
            'Waktu_Mulai'           => $log_pengerjaan->Waktu_Mulai,
            'Waktu_Selesai'         => $log_pengerjaan->Waktu_Selesai,
            'Progress'              => $log_pengerjaan->Progress,
            'Berkas'                => $log_pengerjaan->Berkas,
            'Catatan'               => $log_pengerjaan->Catatan,
        ];
    }
}