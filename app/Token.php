<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use JWTAuth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use SoftDeletes;

    protected $table = 'tokens';
    protected $primaryKey = 'Id_Token';
    public $timestamps = true;
    protected $fillable = [
        'Id_Akun',
        'Username',
        'Password',
    ];

    // protected $dates = [
    //     'created_at',
    //     'updated_at'
    // ];

    // protected $hidden = [
    //     'Id_Akun'
    // ];
    
    public function akuns()
    {
        return $this->belongsTo('App\Akun','Id_Akun');
    }
}
