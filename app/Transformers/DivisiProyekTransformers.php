<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\SubDivisiProyekTransformers;
use App\Sub_Divisi_Proyek;
use App\Divisi_Proyek;

class DivisiProyekTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    protected $defaultIncludes = [
        'Sub_Divisi'
    ];
    public function transform(Divisi_Proyek $divisi_proyek)
    {
        return [
            'Id_Divisi_Proyek'  => $divisi_proyek->Id_Divisi_Proyek,
            'Id_Divisi_Role'    => $divisi_proyek->Id_Divisi_Role,
            'Id_Proyek'         => $divisi_proyek->Id_Proyek,
            'Tanggal_Selesai'   => $divisi_proyek->Tanggal_Selesai,
            'Persentase'        => $divisi_proyek->Persentase,
        ];
    }
    public function includeSubDivisi(Divisi_Proyek $divisi_proyek)
    {
        $subdivisi = $divisi_proyek->sub_divisi_proyeks;
        return $this->collection($subdivisi, new SubDivisiProyekTransformers);
    }
}