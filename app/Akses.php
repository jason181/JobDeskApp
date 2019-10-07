<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akses extends Model
{
    use SoftDeletes;
    protected $table = 'akses';
    protected $primaryKey = 'Id_Akses';
    public $timestamp = true;
    protected $fillable = [
        'Id_Karyawan',
        'Fitur',
        'Deskripsi'
    ];

    public function karyawans()
    {
        return $this->belongsTo('App\Karyawan','Id_Karyawan');
    }
}
