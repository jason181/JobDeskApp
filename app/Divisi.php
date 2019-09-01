<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisi extends Model
{
    //
    use SoftDeletes;
    protected $table = 'divisis';
    protected $primaryKey = 'Id_Divisi';
    public $timestamp = true;
    protected $fillable = [
        'Kode',
        'Deskripsi',
    ];

    public function karyawans()
    {
        return $this->hasMany('App\Karyawan','Id_Divisi');
    }

    public function item_pekerjaans()
    {
        return $this->hasMany('App\Item_Pekerjaan','Id_Divisi');
    }
}
