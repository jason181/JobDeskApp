<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_Data extends Model
{
    //
    use SoftDeletes;
    protected $table = 'user_datas';
    protected $primaryKey = 'Id_User_Data';
    public $timestamp = true;
    protected $fillable = [
        'User_Id',
        'Datetime',
        'Machine_Id',
    ];
}
