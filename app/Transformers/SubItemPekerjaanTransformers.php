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
            'Nama'                  => $sub_item->Nama,
            'Kode'                  => $sub_item->Kode,
            'Tanggal_Selesai'       => $sub_item->Tanggal_Selesai,
            'Persentase'            => $sub_item->Persentase
        ];
    }
}