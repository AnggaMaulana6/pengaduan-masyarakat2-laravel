<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;


class Masyarakat extends Model
{
    use HasFactory;

    protected $table ='masyarakats';

    protected $primaryKey = 'nik';
    

   protected $fillable = [
        'nik',
        'nama',
        'username',
        'password',
        'telp',
    ];
    public function pengaduan(){
        return $this->hasMany(Pengaduan::class);
    }

}
