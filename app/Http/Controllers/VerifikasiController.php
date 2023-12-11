<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;


class VerifikasiController extends Controller
{

    public function __construct(){
        $this->Pengaduan = new Pengaduan();
    }
    public function index(){
        $pengaduans = [
            'title' => 'Data Non Valid',
            'pengaduans' => $this->Pengaduan->dataNonValid(),
        ];
        return view('administrator.verifikasi.nonvalid', $pengaduans);
    }
    public function indexValid(){
        $pengaduans = [
            'title' => 'Data Valid',
            'pengaduans' => $this->Pengaduan->dataValid(),
        ];
        return view('administrator.verifikasi.valid', $pengaduans);
    }
    public function indexDitolak(){
        $pengaduans = [
            'title' => 'Data Non Valid',
            'pengaduans' => $this->Pengaduan->dataDitolak(),
        ];
        return view('administrator.verifikasi.ditolak', $pengaduans);
    }
    public function valid($id_pengaduan){
       $valid = Pengaduan::findorfail($id_pengaduan);
       if(!$valid){
        return redirect('/verifikasi-nonvalid')->with('error', 'Data tidak ditemukan');
      }
      $valid->status = '0';
      $valid->save();
        return redirect('/verifikasi-nonvalid')->with('success', 'Data berhasil divalidasi!');
    }
    public function ditolak($id_pengaduan){
       $ditolak = Pengaduan::findorfail($id_pengaduan);
       if(!$ditolak){
        return redirect('/verifikasi-ditolak')->with('error', 'Data tidak ditemukan');
      }
      $ditolak->status = 'ditolak';
      $ditolak->save();
        return redirect('/verifikasi-nonvalid')->with('success', 'Data berhasil ditolak!');
    }
}
