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
        return [
            'Id_Log_Pengerjaan'     => $log_pengerjaan->Id_Log_Pengerjaan,
            'Id_Sub_Item_Pekerjaan' => $log_pengerjaan->Id_Sub_Item_Pekerjaan,
            'Id_Akun'               => $log_pengerjaan->Id_Akun,
            'Waktu_Mulai'           => $log_pengerjaan->Waktu_Mulai,
            'Waktu_Selesai'         => $log_pengerjaan->Waktu_Selesai,
            'Persentase'            => $log_pengerjaan->Persentase,
            'Berkas'                => $log_pengerjaan->Berkas,
            'Catatan'               => $log_pengerjaan->Catatan
        ];
    }
}