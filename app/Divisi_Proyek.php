<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisi_Proyek extends Model
{
    //
    use SoftDeletes;
    protected $table = 'divisi_proyeks';
    protected $primaryKey = 'Id_Divisi_Proyek';
    public $timestamp = true;
    protected $fillable = [
        'Id_Divisi_Role',
        'Id_Proyek',
        'Nama',
        'Tanggal_Selesai',
        'Durasi',
        'Persentase',
    ];

    public function sub_divisi_proyeks()
    {
        return $this->hasMany('App\Sub_Divisi_Proyek','Id_Divisi_Proyek');
    }

    public function divisi_roles()
    {
        return $this->belongsTo('App\Divisi_Role','Id_Divisi_Role');
    }

    public function proyeks()
    {
        return $this->belongsTo('App\Proyek','Id_Proyek');
    }
}
