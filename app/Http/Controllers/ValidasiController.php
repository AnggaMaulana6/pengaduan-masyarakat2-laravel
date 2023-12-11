<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class ValidasiController extends Controller
{
    public function __construct(){
        $this->Pengaduan = new Pengaduan();
    }
    public function indexProses(){
        $pengaduans = [
            'title' => 'Data Proses',
            'pengaduans' => $this->Pengaduan->dataProses(),
        ];
        return view('administrator.validasi.proses', $pengaduans);
    }
    public function indexSelesai(){
        $pengaduans = [
            'title' => 'Data Selesai',
            'pengaduans' => $this->Pengaduan->dataSelesai(),
        ];
        return view('administrator.validasi.selesai', $pengaduans);
    }
    public function proses($id_pengaduan){
       $proses = Pengaduan::findorfail($id_pengaduan);
       if(!$proses){
        return redirect('/validasi-proses')->with('error', 'Data tidak ditemukan');
      }
      $proses->status = 'proses';
      $proses->save();
        return redirect('/validasi-proses')->with('success', 'Data berhasil diproses!');
    }
    public function selesai($id_pengaduan){
       $selesai = Pengaduan::findorfail($id_pengaduan);
       if(!$selesai){
        return redirect('/validasi-selesai')->with('error', 'Data tidak ditemukan');
      }
      $selesai->status = 'selesai';
      $selesai->save();
        return redirect('/validasi-selesai')->with('success', 'Aduan berhasil diselesaikan!');
    }
}
