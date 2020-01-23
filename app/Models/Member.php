<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model 
{
    protected $fillable = [
        'nama_member', 'alamat', 'no_telp'
    ];

    public $timestamps = true;

    public function sewa()
    {
    	return $this->hasMany('App\Models\Sewa');
    }
    
}
