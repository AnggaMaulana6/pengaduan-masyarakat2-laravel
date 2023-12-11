<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
class RegistrasiController extends Controller
{
    public function index(){
        return view("masyarakat.registrasi");
    }
    public function indexPet(){
        return view("administrator.registrasiPet");
    }
    public function daftarPet(Request $request){
        $validateData = $request->validate([
            'nama_petugas' => 'required|min:3|max:35',
            'email' => 'required|email',
            'telp' => 'required|min:11|max:13',
            'username' => 'required|min:3|max:50|unique:masyarakats',
            'password' => 'required|min:5|max:35',
            'level' => 'required',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        Petugas::create($validateData);

        return redirect('login')->with('success', 'Registrasi Berhasil, Silakan Login!');
    }
    public function daftarMas(Request $request){
        $validateData = $request->validate([
            'nik' => 'required|max:16',
            'nama' => 'required|max:35',
            'telp' => 'required|min:11|max:13',
            'username' => 'required|min:3|max:50|unique:masyarakats',
            'password' => 'required|min:5|max:35',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        Masyarakat::create($validateData);

        return redirect('login')->with('success', 'Registrasi Berhasil, Silakan Login!');
    }
}
