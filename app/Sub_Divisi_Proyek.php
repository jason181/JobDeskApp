<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub_Divisi_Proyek extends Model
{
    //
    use SoftDeletes;
    protected $table = 'sub_divisi_proyeks';
    protected $primaryKey = 'Id_Sub_Divisi_Proyek';
    public $timestamp = true;
    protected $fillable = [
        'Id_Divisi_Proyek',
        'Nama',
        'Tanggal_Selesai',
        'Durasi',
        'Persentase'
    ];

    public function item_pekerjaans()
    {
        return $this->hasMany('App\Item_Pekerjaan','Id_Sub_Divisi_Proyek');
    }

    public function divisi_proyeks()
    {
        return $this->belongsTo('App\Divisi_Proyek','Id_Divisi_Proyek');
    }
}
