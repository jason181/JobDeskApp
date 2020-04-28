<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scanlog extends Model
{
    use SoftDeletes;
    protected $table = 'tb_scanlog';
    protected $primaryKey = 'Id_Scanlog';
    public $timestamp = true;
    protected $fillable = [
        'Id_Device',
        'Id_User',
        'Verify_Mode',
        'IO_Mode',
        'Work_Code',
    ];

    public function devices()
    {
        return $this->belongsTo('App\Device','Id_Device');
    }

    public function users()
    {
        return $this->belongsTo('App\User_Data','Id_User');
    }
}
