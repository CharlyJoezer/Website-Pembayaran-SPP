<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $guarded = ['id_pembayaran'];


    public function petugas(){
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
    public function spp(){
        return $this->belongsTo(Spp::class, 'id_spp', 'id_spp');
    }
    public function user(){
        return $this->belongsTo(User::class, 'nisn', 'nisn')->select('');
    }
}
