<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Divisi_Role;

class DivisiRoleTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Divisi_Role $divisi)
    {
        return [
            'Id_Divisi_Role'=> $divisi->Id_Divisi_Role,
            'Kode'          => $divisi->Kode,
            'Deskripsi'     => $divisi->Deskripsi
        ];
    }
}