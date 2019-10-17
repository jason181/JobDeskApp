<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akun extends Model
{
    //
    use SoftDeletes;
    protected $table = 'akuns';
    protected $primaryKey = 'Id_Akun';
    public $timestamp = true;
    protected $fillable = [
        // 'Id_Karyawan'
        'Username',
        'Password'
    ];

    public function karyawans()
    {
        return $this->hasOne('App\Karyawan','Id_Akun');
    }

    public function log_sesis()
    {
        return $this->hasMany('App\Log_Sesi','Id_Akun');
    }

    public function log_pengerjaans()
    {
        return $this->hasMany('App\Log_Pengerjaan','Id_Akun');
    }

    public function akses_pekerjaans()
    {
        return $this->hasMany('App\Akses_Pekerjaan','Id_Akun');
    }

    public function tokens()
    {
        return $this->hasMany('App\Token','Id_Akun');
    }

}
