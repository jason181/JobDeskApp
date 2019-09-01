<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log_Pengerjaan extends Model
{
    use SoftDeletes;
    protected $table = 'log_pengerjaans';
    protected $primaryKey = 'Id_Log_Pengerjaan';
    public $timestamp = true;
    protected $fillable = [
        'Id_Sub_Item_Pekerjaan',
        'Id_Akun',
        'Waktu_Mulai',
        'Waktu_Selesai',
        'Persentase',
        'Berkas',
        'Catatan'
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
