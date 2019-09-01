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
        'Id_Divisi',
        'Item',
        'Kode',
        'Satuan',
        'Durasi'
    ];
    public function proyeks()
    {
        return $this->belongsTo('App\Proyek','Id_Proyek');
    }

    public function divisis()
    {
        return $this->belongsTo('App\Divisi','Id_Divisi');
    }

    public function sub_item_pekerjaans()
    {
        return $this->hasMany('App\Sub_Item_Pekerjaan','Id_Item_Pekerjaan');
    }
}
