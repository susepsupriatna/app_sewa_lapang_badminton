<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model 
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'sewa_id', 'total_bayar', 'status'
    ];	

    public $timestamps = true;
}
