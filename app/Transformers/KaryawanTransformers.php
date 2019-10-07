<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\AksesTransformers;
use App\Karyawan;
use App\Akses;
class KaryawanTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    protected $defaultIncludes = [
        'Akses'
    ];
    public function transform(Karyawan $karyawan)
    {
        return [
            'Id_Karyawan'   => $karyawan->Id_Karyawan,
            'Id_Divisi_Role'=> $karyawan->Id_Divisi_Role,
            'Divisi'        => $karyawan->divisi_roles->Deskripsi,
            'Id_Jabatan'    => $karyawan->Id_Jabatan,
            'Id_Akun'       => $karyawan->Id_Akun,
            'Username'      => $karyawan->akuns->Username,
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
    public function includeAkses(Karyawan $karyawan)
    {
        $akses = $karyawan->akses;
        return $this->collection($akses, new AksesTransformers);
    }
}