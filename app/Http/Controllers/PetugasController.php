<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Http\Requests\StorePetugasRequest;
use App\Http\Requests\UpdatePetugasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('administrator.users.petugas.DataPet',[
            'title' => 'Data Petugas',
            'users' => Petugas::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.users.petugas.registrasiPet',[
            'title' => 'Tambah Petugas'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePetugasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return redirect('/data-petugas')->with('success', 'Registrasi Berhasil, Petugas berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function show(Petugas $petugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function edit($id_petugas)
    {
        $petugas = Petugas::findorfail($id_petugas);
        return view('administrator.users.petugas.editPet',[
            'title' => 'Edit Petugas'
        ], compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePetugasRequest  $request
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_petugas)
    {
        $rules = [
            'nama_petugas' => 'required|max:35',
            'email' => 'required|email',
            'username' => ['required', 'min:3', 'max:255'],
            'password' => 'required|min:5|max:255',
            'telp' => 'required|min:11|max:13',
            'level' => 'required'
        ];
        
        $validateData = $request->validate($rules);
        $validateData['password'] = Hash::make($validateData['password']);
        Petugas::where('id_petugas', $id_petugas)->update($validateData);
        
        return redirect('/data-petugas')->with('success', 'Data Aduan Berhasil Diubah!');
// dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_petugas)
    {

        Petugas::where('id_petugas', $id_petugas)->delete();

        return redirect('/data-petugas')->with('success', 'Data Petugas telah dihapus');

    }
}
