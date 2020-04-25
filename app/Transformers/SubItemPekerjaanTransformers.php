<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sub_Item_Pekerjaan;

class SubItemPekerjaanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Sub_Item_Pekerjaan $sub_item)
    {
        return [
            'Id_Sub_Item_Pekerjaan' => $sub_item->Id_Sub_Item_Pekerjaan,
            'Id_Item_Pekerjaan'     => $sub_item->Id_Item_Pekerjaan,
            'Task'                  => $sub_item->item_pekerjaans->Nama,
            'Nama'                  => $sub_item->Nama,
            'Kode'                  => $sub_item->Kode,
            'Deskripsi'             => $sub_item->Deskripsi,
            'Tanggal_Selesai'       => $sub_item->Tanggal_Selesai,
            'Durasi'                => $sub_item->Durasi,
            'Persentase'            => $sub_item->Persentase,
            'Prestasi_Kerja'        => $sub_item->Prestasi_Kerja
        ];
    }
}