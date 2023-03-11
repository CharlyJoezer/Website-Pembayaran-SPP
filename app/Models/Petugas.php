<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Petugas extends Model
{
    use HasFactory;
    
    public function getAuthIdentifierName()
    {
        return 'id_petugas';
    }

    protected $table = 'petugas';
    protected $fillable = ['id_petugas', 'password'];

}
