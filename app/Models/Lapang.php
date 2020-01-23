<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapang extends Model 
{
    protected $table = 'lapang';
    
    protected $fillable = [
        'nama_lapang', 'jenis_karpet', 'harga_per_jam', 'foto'
    ];

    public $timestamps = true;

    public function sewa()
    {
    	return $this->hasMany('App\Models\Sewa');
    }

    
}
