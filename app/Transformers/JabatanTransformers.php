<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Jabatan;

class JabatanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Jabatan $jabatan)
    {
        return [
            'Id_Jabatan'    => $jabatan->Id_Jabatan,
            'Kode'          => $jabatan->Kode,
            'Keterangan'    => $jabatan->Keterangan
        ];
    }
}