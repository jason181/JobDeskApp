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
            'Id_Sub_Item_Pekerjaan' => $akses_pekerjaan->Id_Sub_Item_Pekerjaan,
            'Id_Akun'               => $akses_pekerjaan->Id_Akun,
            'Status'                => $akses_pekerjaan->Status,
            'Verifikasi'            => $akses_pekerjaan->Verifikasi
        ];
    }
}