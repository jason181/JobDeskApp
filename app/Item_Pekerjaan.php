<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Pekerjaan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'item_pekerjaans';
    protected $primaryKey = 'Id_Item_Pekerjaan';
    public $timestamp = true;
    protected $fillable = [
        'Id_Proyek',
        'Id_Divisi_Role',
        'Id_Sub_Divisi_Proyek',
        'Nama',
        'Kode',
        'Satuan',
        'Tanggal_Selesai',
        'Persentase'
    ];
    public function proyeks()
    {
        return $this->belongsTo('App\Proyek','Id_Proyek');
    }

    public function divisi_roles()
    {
        return $this->belongsTo('App\Divisi_Role','Id_Divisi_Role');
    }
    public function sub_divisi_proyeks()
    {
        return $this->belongsTo('App\Sub_Divisi_Proyek','Id_Sub_Divisi_Proyek');
    }

    public function sub_item_pekerjaans()
    {
        return $this->hasMany('App\Sub_Item_Pekerjaan','Id_Item_Pekerjaan');
    }
}
