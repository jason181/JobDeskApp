<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scanlog extends Model
{
    use SoftDeletes;
    protected $table = 'tb_template';
    protected $primaryKey = 'Id_Template';
    public $timestamp = true;
    protected $fillable = [
        'Id_User',
        'Finger_Idx',
        'Alg_Ver',
        'Template',
    ];

    public function users()
    {
        return $this->belongsTo('App\User_Data','Id_User');
    }
}
