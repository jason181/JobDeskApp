<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'jabatans';
    protected $primaryKey = 'Id_Jabatan';
    public $timestamp = true;
    protected $fillable = [
        'Kode',
        'Deskripsi',
    ];

    public function karyawans()
    {
        return $this->hasMany('App\Karyawan','Id_Jabatan');
    }
}
