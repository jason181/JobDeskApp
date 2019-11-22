<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akses_Pekerjaan extends Model
{
    use SoftDeletes;
    protected $table = 'akses_pekerjaans';
    protected $primaryKey = 'Id_Akses_Pekerjaan';
    public $timestamp = true;
    protected $fillable = [
        'Id_Sub_Item_Pekerjaan',
        'Id_Akun',
        'Status',
        'Verifikasi',
        'Deskripsi'
    ];
    
    public function sub_item_pekerjaans()
    {
        return $this->belongsTo('App\Sub_Item_Pekerjaan','Id_Sub_Item_Pekerjaan');
    }

    public function akuns()
    {
        return $this->belongsTo('App\Akun','Id_Akun');
    }
}
