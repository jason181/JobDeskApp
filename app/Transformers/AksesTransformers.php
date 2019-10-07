<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Akses;

class AksesTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Akses $akses)
    {
        return [
            'Id_Akses'    => $akses->Id_Akses,
            'Id_Karyawan' => $akses->Id_Karyawan,
            'Fitur'       => $akses->Fitur,
            'Deskripsi'   => $akses->Deskripsi,

        ];
    }
}