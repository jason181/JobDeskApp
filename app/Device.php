<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    protected $table = 'tb_device';
    protected $primaryKey = 'Id_Device';
    public $timestamp = true;
    protected $fillable = [
        'No',
        'Server_IP',
        'Server_Port',
        'Device_SN',
    ];

    public function scanlogs()
    {
        return $this->hasMany('App\Scanlog','Id_Device');
    }
}
