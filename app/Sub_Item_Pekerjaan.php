<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub_Item_Pekerjaan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'sub_item_pekerjaans';
    protected $primaryKey = 'Id_Sub_Item_Pekerjaan';
    public $timestamp = true;
    protected $fillable = [
        'Id_Item_Pekerjaan',
        'Nama',
        'Kode',
        'Deskripsi',
        'Tanggal_Selesai',
        'Persentase',
    ];
    
    public function log_pengerjaans()
    {
        return $this->hasMany('App\Log_Pengerjaan','Id_Sub_Item_Pekerjaan');
    }

    public function akses_pekerjaans()
    {
        return $this->hasMany('App\Akses_Pekerjaan','Id_Sub_Item_Pekerjaan');
    }

    public function item_pekerjaans()
    {
        return $this->belongsTo('App\Item_Pekerjaan','Id_Item_Pekerjaan');
    }
}
