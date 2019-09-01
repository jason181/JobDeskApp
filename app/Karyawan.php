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
        'Id_Divisi',
        'Id_Jabatan',
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

    public function divisis()
    {
        return $this->belongsTo('App\Divisi','Id_Divisi');
    }

    public function jabatans()
    {
        return $this->belongsTo('App\Jabatan','Id_Jabatan');
    }

    public function akuns()
    {
        return $this->hasOne('App\Akun','Id_Karyawan');
    }

}
