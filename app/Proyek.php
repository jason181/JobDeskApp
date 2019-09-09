<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyek extends Model
{
    //
    use SoftDeletes;
    protected $table = 'proyeks';
    protected $primaryKey = 'Id_Proyek';
    public $timestamp = true;
    protected $fillable = [
        'Kode',
        'Nama',
        'Pemilik',
        'Alamat',
        'Nilai',
        'Target_Outcome',
        'Tanggal_Mulai',
        'Tanggal_Selesai',
        'Catatan'
    ];

    public function item_pekerjaans()
    {
        return $this->hasMany('App\Item_Pekerjaan','Id_Proyek');
    }
}
