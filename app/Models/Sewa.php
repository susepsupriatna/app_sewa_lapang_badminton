<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sewa extends Model 
{
    protected $table = 'sewa';
    
    protected $fillable = [
        'user_id', 'member_id', 'lapang_id', 'tanggal', 'jam_mulai', 'jam_selesai'
    ];

    public $timestamps = true;
    

    public function pembayaran()
    {
    	return $this->hasOne('App\Models\Pembayaran');
    }

    public function member()
    {
    	return $this->belongsTo('App\Models\Member');
    }

    public function lapang()
    {
    	return $this->belongsTo('App\Models\Lapang');
    }
}
