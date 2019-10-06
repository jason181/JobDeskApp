<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Karyawan;

class KaryawanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Karyawan $karyawan)
    {
        return [
            'Id_Karyawan'   => $karyawan->Id_Karyawan,
            'Id_Divisi_Role'=> $karyawan->Id_Divisi_Role,
            'Divisi'        => $karyawan->divisi_roles->Deskripsi,
            'Id_Jabatan'    => $karyawan->Id_Jabatan,
            'Jabatan'       => $karyawan->jabatans->Deskripsi,
            'Kode'          => $karyawan->Kode,
            'Nama'          => $karyawan->Nama,
            'Alamat'        => $karyawan->Alamat,
            'Telepon'       => $karyawan->Telepon,
            'Tanggal_Masuk' => $karyawan->Tanggal_Masuk,
            'Grade'         => $karyawan->Grade,
            'KTP'           => $karyawan->KTP,
            'Nomor_Asosiasi'=> $karyawan->Nomor_Asosiasi,
            'Nomor_SKA'     => $karyawan->Nomor_SKA
        ];
    }
}