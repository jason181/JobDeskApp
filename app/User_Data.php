<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Data extends Model
{
    use SoftDeletes;
    protected $table = 'tb_user';
    protected $primaryKey = 'Id_User';
    public $timestamp = true;
    protected $fillable = [
        'Nama',
        'Password',
        'RFID',
        'Privilege',
    ];

    public function scanlogs()
    {
        return $this->hasMany('App\Scanlogs','Id_User');
    }

    public function templates()
    {
        return $this->hasMany('App\Template','Id_User');
    }
}
