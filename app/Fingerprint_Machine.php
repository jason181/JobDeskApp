<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Fingerprint_Machine extends Model
{
    //
    use SoftDeletes;
    protected $table = 'fingerprint_machines';
    protected $primaryKey = 'Id_Fingerprint_Machine';
    public $timestamp = true;
    protected $fillable = [
        'IP',
        'Comkey',
        'Status',
    ];
}
