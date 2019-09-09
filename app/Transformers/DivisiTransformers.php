<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Divisi;

class DivisiTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Divisi $divisi)
    {
        return [
            'Id_Divisi'     => $divisi->Id_Divisi,
            'Kode'          => $divisi->Kode,
            'Keterangan'    => $divisi->Keterangan
        ];
    }
}