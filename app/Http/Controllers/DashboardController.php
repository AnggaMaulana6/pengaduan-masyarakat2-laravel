<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Masyarakat;
use App\Models\Petugas;
class DashboardController extends Controller
{
    public function index(){
        // Administrator
        $dataNonValid = Pengaduan::whereNull('status')->count();
        $valid = Pengaduan::where('status', '0')->count();
        $proses = Pengaduan::where('status', 'proses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();
        $ditolak = Pengaduan::where('status', 'ditolak')->count();

        // Dashboard untuk Masyarakat
        $get_nonvalid = Pengaduan::whereNull('status')
        ->when(auth()->user()->nik, function($query){
            return $query->where('nik', auth()->user()->nik);
        })->count();
        
        $get_valid = Pengaduan::where('status', '0')
        ->when(auth()->user()->nik, function($query){
            return $query->where('nik', auth()->user()->nik);
        })->count();

        $get_proses = Pengaduan::where('status', 'proses')
        ->when(auth()->user()->nik, function($query){
            return $query->where('nik', auth()->user()->nik);
        })->count();

        $get_selesai = Pengaduan::where('status', 'selesai')
        ->when(auth()->user()->nik, function($query){
            return $query->where('nik', auth()->user()->nik);
        })->count();

        $aduanjmlh = Pengaduan::where('nik', auth()->user()->nik)->count();

        $get_ditolak = Pengaduan::where('status', 'ditolak')
        ->when(auth()->user()->nik, function($query){
            return $query->where('nik', auth()->user()->nik);
        })->count();

        return view('dashboard',[
            'title' => 'Dashoard'
        ], compact('dataNonValid', 'valid', 'proses', 'selesai', 'ditolak', 'aduanjmlh', 'get_nonvalid', 'get_valid', 'get_proses', 'get_selesai', 'get_ditolak'));
    }
}
