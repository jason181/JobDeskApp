<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;
    protected $table = 'karyawans';
    protected $primaryKey = 'Id_Karyawan';
    public $timestamp = true;
    protected $fillable = [
        'Id_Divisi_Role',
        'Id_Jabatan',
        'Id_Akun',
        'Kode',
        'Nama',
        'Alamat',
        'Telepon',
        'Tanggal_Masuk',
        'Grade',
        'KTP',
        'Nomor_Asosiasi',
        'Nomor_SKA'
    ];

    public function divisi_roles()
    {
        return $this->belongsTo('App\Divisi_Role','Id_Divisi_Role');
    }

    public function jabatans()
    {
        return $this->belongsTo('App\Jabatan','Id_Jabatan');
    }

    public function akuns()
    {
        return $this->belongsTo('App\Akun','Id_Akun');
    }
}
