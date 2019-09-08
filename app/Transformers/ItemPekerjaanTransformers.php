<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Item_Pekerjaan;

class ItemPekerjaanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Item_Pekerjaan $item)
    {
        return [
            'Id_Item_Pekerjaan' => $item->Id_Item_Pekerjaan,
            'Id_Proyek'         => $item->Id_Proyek,
            'Id_Divisi'         => $item->Id_Divisi,
            'Item'              => $item->Item,
            'Kode'              => $item->Kode,
            'Satuan'            => $item->Satuan,
            'Durasi'            => $item->Durasi,
        ];
    }
}