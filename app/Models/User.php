<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function getAuthIdentifierName()
    {
        return 'nisn';
    }
    protected $fillable = ['nisn','nis','id_kelas','id_spp','nama','alamat','no_telp', 'password', 'foto'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

}
