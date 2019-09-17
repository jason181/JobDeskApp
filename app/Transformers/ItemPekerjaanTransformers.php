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
            'Id_Divisi_Role'    => $item->Id_Divisi_Role,
            'Nama'              => $item->Nama,
            'Kode'              => $item->Kode,
            'Satuan'            => $item->Satuan,
            'Tanggal_Selesai'   => $item->Tanggal_Selesai,
            'Persentase'        => $item->Durasi,
        ];
    }
}