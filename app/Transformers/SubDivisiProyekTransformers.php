<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sub_Divisi_Proyek;

class SubDivisiProyekTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Sub_Divisi_Proyek $sub_divisi_proyek)
    {
        return [
            'Id_Sub_Divisi_Proyek'  => $sub_divisi_proyek->Id_Sub_Divisi_Proyek,
            'Id_Divisi_Proyek'      => $sub_divisi_proyek->Id_Divisi_Proyek,
            'Tanggal_Selesai'       => $sub_divisi_proyek->Tanggal_Selesai,
            'Persentase'            => $sub_divisi_proyek->Persentase
        ];
    }
}