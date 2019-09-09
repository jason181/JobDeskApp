<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Akun;

class AkunTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Akun $akun)
    {
        return [
            'Id_Akun'       => $akun->Id_Akun,
            'Id_Karyawan'   => $akun->Id_Karyawan,
            'Username'      => $akun->Username,
            'Password'      => $akun->Password
        ];
    }
}