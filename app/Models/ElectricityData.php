<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricityData extends Model
{
    //
    protected $table = 'electricity_data';
    protected $primaryKey = 'id';


    public $timestamps = false;

    protected $fillable = [
        'voltage',
        'current',
        'power',
        'energy',
    ];


    

    
}
