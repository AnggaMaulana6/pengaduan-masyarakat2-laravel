<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tanggapan extends Model
{
    use HasFactory;
    protected $table = 'tanggapans';
    protected $primaryKey = 'id_tanggapan';
    protected $guarded = ['id_tanggapan'];

    public function dataTanggapan($id_pengaduan){
        return DB::table('tanggapans')
        ->leftjoin('petugas', 'petugas.id_petugas', '=', 'tanggapans.id_petugas')
        ->where('id_pengaduan', '=', $id_pengaduan)
        ->get();
    }
    public function getPengaduan($id_pengaduan){
        return DB::table('pengaduans')
        ->leftjoin('masyarakats', 'masyarakats.nik', '=', 'pengaduans.nik')
        ->where('id_pengaduan', '=', $id_pengaduan)
        ->get();
    }
}
