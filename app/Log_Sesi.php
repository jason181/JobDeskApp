<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log_Sesi extends Model
{
    use SoftDeletes;
    protected $table = 'log_sesis';
    protected $primaryKey = 'Id_Log_Sesi';
    public $timestamp = true;
    protected $fillable = [
        'Id_Akun',
        'Waktu',
        'Keterangan'
    ];

    public function akuns()
    {
        return $this->belongsTo('App\Akun','Id_Akun');
    }
}
