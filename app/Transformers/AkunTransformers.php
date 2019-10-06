<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\AksesTransformers;
use App\Akun;
use App\Akses;

class AkunTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    protected $defaultIncludes = [
        'akses'
    ];

    public function transform(Akun $akun)
    {
        return [
            'Id_Akun'       => $akun->Id_Akun,
            'Username'      => $akun->Username,
            'Password'      => $akun->Password,
            'Name'          => optional($akun->karyawans)->Nama,
            'Divisi'        => optional($akun->divisi_roles)->Deskripsi,
            'Jabatan'       => optional($akun->jabatans)->Deskripsi,
        ];
    }

    public function includeAkses(Akun $akun)
    {
        $akses = $akun->karyawans->akses;
        return $this->collection($akses, new AksesTransformers);
    }
}