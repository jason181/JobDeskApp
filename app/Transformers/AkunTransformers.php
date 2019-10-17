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
        'Akses'
    ];

    public function transform(Akun $akun)
    {
        return [
            'Id_Akun'       => $akun->Id_Akun,
            // 'Id_Karyawan'   => optional($akun->karyawans)->Id_Karyawan,
            // 'Id_Karyawan'   => $akun->Id_Karyawan,
            'Username'      => $akun->Username,
            'Password'      => $akun->Password,
            'Name'          => optional($akun->karyawans)->Nama,
            'Divisi'        => optional($akun->karyawans->divisi_roles)->Deskripsi,
            'Jabatan'       => optional($akun->karyawans->jabatans)->Deskripsi,
        ];
    }

    public function includeAkses(Akun $akun)
    {
        $akses = $akun->karyawans->akses;
        return $this->collection($akses, new AksesTransformers);
    }
}