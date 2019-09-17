<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Divisi_Proyek;

class DivisiProyekTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Divisi_Proyek $divisi_proyek)
    {
        return [
            'Id_Divisi_Proyek'  => $divisi_proyek->Id_Divisi_Proyek,
            'Id_Divisi_Role'    => $divisi_proyek->Id_Divisi_Role,
            'Id_Proyek'         => $divisi_proyek->Id_Proyek,
            'Tanggal_Selesai'   => $divisi_proyek->Tanggal_Selesai,
            'Persentase'        => $divisi_proyek->Persentase
        ];
    }
}