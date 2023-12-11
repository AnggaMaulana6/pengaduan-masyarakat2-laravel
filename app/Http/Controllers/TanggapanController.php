<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tanggapan;
use App\Models\Pengaduan;

class TanggapanController extends Controller
{
    public function __construct(){
        $this->Tanggapan = new Tanggapan();
    }
    public function index($id_pengaduan){
        //Mencari data berdasarkan 2 tabel dengan parameter 
        $pengaduan =DB::table('pengaduans')
        ->leftjoin('masyarakats', 'masyarakats.nik', '=', 'pengaduans.nik')
        ->where('id_pengaduan', '=', $id_pengaduan)
        ->first();

        if($pengaduan->status == NULL){
            $status = 'Non Valid';
        }elseif($pengaduan->status == '0'){
            $status = 'Valid';
        }else{
            $status = $pengaduan->status;
        }

        // Untuk Menampilkan data Tanggapan yang terdiri dari 3 tabel
        $tanggapan = ([
            'title' => 'Data Tanggapan',
            'tanggapan' =>$this->Tanggapan->dataTanggapan($id_pengaduan),
            // 'pengaduann' =>$this->Tanggapan->getPengaduan($id_pengaduan)
        ]);
    
        // $title = 'Tanggapan';
        return view('administrator.validasi.tanggapan', compact('pengaduan', 'status'), $tanggapan);
        
    }

    public function simpanTanggapan(Request $request, $id_pengaduan){
         //Mencari data berdasarkan 2 tabel dengan parameter 
         $pengaduan =DB::table('pengaduans')
         ->leftjoin('masyarakats', 'masyarakats.nik', '=', 'pengaduans.nik')
         ->where('id_pengaduan', '=', $id_pengaduan)
         ->first();
         
         Tanggapan::create([
            'tanggapan' => $request->tanggapan,
            'tgl_tanggapan' => now(),
            'id_petugas' => auth()->user()->id_petugas,
            'id_pengaduan' => $id_pengaduan,
         ]);
         if($pengaduan->status == '0'){
            return redirect('/verifikasi-valid')->with('success', 'Aduan Berhasil ditanggapi!');
         }else{
            return redirect('/validasi-proses')->with('success', 'Aduan Berhasil ditanggapi!');
         }
    }
}
