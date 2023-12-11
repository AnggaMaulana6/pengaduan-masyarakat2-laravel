<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masyarakat.pengaduan.pengaduan',[
            'title' => 'Tulis Aduan',
            'pengaduans' => Pengaduan::where('nik', auth()->user()->nik)->get() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masyarakat.pengaduan.pengaduanAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'tgl_pengaduan' => 'required',
            'foto' => 'required|image|max:1024',
            'isi_laporan' => 'required',
        ]);

        if($request->file('foto')){
            $validateData['foto'] = $request->file('foto')->store('foto-aduan');
        }

        $validateData['nik'] = auth()->user()->nik;
        Pengaduan::create($validateData);

        return redirect('/pengaduan')->with('success', 'Aduan Berhasil ditambahkan');
    // dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function show($id_pengaduan)
    {
        $pengaduan = Pengaduan::findorfail($id_pengaduan);
        if($pengaduan->status == NULL){
            $status = 'Non Valid';
        }elseif($pengaduan->status == '0'){
            $status = 'Valid';
        }else{
            $status = $pengaduan->status;
        }

        return view('masyarakat.pengaduan.lihat', [
            'title' => 'Lihat Aduan'
        ], compact('pengaduan', 'status'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pengaduan)
    {
        $pengaduan = Pengaduan::findorfail($id_pengaduan);
        if($pengaduan->status == NULL){
            $status = 'Non Valid';
        }elseif($pengaduan->status == '0'){
            $status = 'Valid';
        }else{
            $status = $pengaduan->status;
        }
        return view('masyarakat.pengaduan.pengaduanEdit',[
            'title' => 'Edit Pengaduan'
        ], compact('pengaduan', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id_pengaduan)
    {
        $pengaduan = Pengaduan::findorfail($id_pengaduan);
        $rules = [
            'tgl_pengaduan' => 'required',
            'foto' => 'required|image|file|max:1024',
            'isi_laporan' => 'required',
            'status' => 'required'
        ];

        $validateData = $request->validate($rules);

        if($request->file('foto')){
            if($request->oldFoto){
                Storage::delete($request->oldFoto);
            }
            $validateData['foto'] = $request->file('foto')->store('foto-aduan');
        }

        $validateData['nik'] = auth()->user()->nik;

        Pengaduan::where('id_pengaduan', $id_pengaduan)->update($validateData);

        return redirect('/pengaduan')->with('success', 'Data Aduan Berhasil Diubah!');
        // dd($id_pengaduan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pengaduan)
    {
        $pengaduan = Pengaduan::findorfail($id_pengaduan);

        if($pengaduan->foto){
            Storage::delete($pengaduan->foto);
        }
        Pengaduan::where('id_pengaduan', $id_pengaduan)->delete();
        
        return redirect('/pengaduan')->with('success', 'Data berhasil dihapus!');
    }
    public function lihatTanggapan($id_pengaduan){
        $tanggapan = DB::table('pengaduans')
        ->join('tanggapans', 'pengaduans.id_pengaduan', '=', 'tanggapans.id_pengaduan')
        ->join('petugas', 'tanggapans.id_petugas', '=', 'petugas.id_petugas')
        // ->select('pengaduans.*', 'tanggapans.tanggapan', 'petugas.nama_petugas')
        ->where('pengaduans.id_pengaduan', $id_pengaduan)
        ->get();
    
    
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
            return view('masyarakat.pengaduan.lihatTanggapan',[
                'title' => 'Lihat Tanggapan',
            ], compact('pengaduan', 'status', 'tanggapan'), $tanggapan);
        }
}
