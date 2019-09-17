<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisi_Role extends Model
{
    //
    use SoftDeletes;
    protected $table = 'divisi_roles';
    protected $primaryKey = 'Id_Divisi_Role';
    public $timestamp = true;
    protected $fillable = [
        'Kode',
        'Deskripsi',
    ];

    public function karyawans()
    {
        return $this->hasMany('App\Karyawan','Id_Divisi_Role');
    }

    public function item_pekerjaans()
    {
        return $this->hasMany('App\Item_Pekerjaan','Id_Divisi_Role');
    }
    
    public function divisi_proyeks()
    {
        return $this->hasMany('App\Divisi_Proyek','Id_Divisi_Role');
    }
}
