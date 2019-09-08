<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Proyek;

class ProyekTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Proyek $proyek)
    {
        return [
            'Id_Proyek'         => $proyek->Id_Proyek,
            'Kode'              => $proyek->Kode,
            'Nama'              => $proyek->Nama,
            'Pemilik'           => $proyek->Pemilik,
            'Alamat'            => $proyek->Alamat,
            'Nilai'             => $proyek->Nilai,
            'Target_Outcome'    => $proyek->Target_Outcome,
            'Tanggal_Mulai'     => $proyek->Tanggal_Mulai,
            'Tanggal_Selesai'   => $proyek->Tanggal_Selesai,
            'Catatan'           => $proyek->Catatan
        ];
    }
}