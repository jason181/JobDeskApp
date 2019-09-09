<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Log_Sesi;

class LogSesiTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Log_Sesi $log_sesi)
    {
        return [
            'Id_Log_Sesi'   => $log_sesi->Id_Log_Sesi,
            'Id_Akun'       => $log_sesi->Id_Akun,
            'Waktu'         => $log_sesi->Waktu,
            'Keterangan'    => $log_sesi->Keterangan
        ];
    }
}