<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasyarakatRequest;
use App\Http\Requests\UpdateMasyarakatRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Masyarakat;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.users.masyarakat.DataMas', [
            'title' => 'Data Masyarakat',
            'users' => Masyarakat::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.users.masyarakat.RegistrasiMas', [
            'title' => 'Data Masyarakat',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasyarakatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nik' => 'required|min:11|max:16',
            'nama' => 'required|min:3|max:35',
            'telp' => 'required|min:11|max:14',
            'username' => 'required|min:3|max:35|unique:masyarakats',
            'password' => 'required|min:5|max:35',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        Masyarakat::create($validateData);

        return redirect('/data-masyarakat')->with('success', 'Data Masyarakat Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Masyarakat  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function show($nik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Masyarakat  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit($nik)
    {
        $masyarakat = Masyarakat::findorfail($nik);

        return view('administrator.users.masyarakat.EditMas', [
            'title' => 'Data Masyarakat',
            'masyarakat' => $masyarakat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasyarakatRequest  $request
     * @param  \App\Models\Masyarakat  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nik)
    {
        $rules = [
            'nik' => 'required|max:16',
            'nama' => 'required|min:3|max:35',
            'telp' => 'required|min:11|max:14',
            'username' => 'required|min:3|max:35',
            'password' => 'required|min:5',
        ];

        $validateData = $request->validate($rules);
        $validateData['password'] = Hash::make($validateData['password']);

        Masyarakat::where('nik', $nik)->update($validateData);

        return redirect('/data-masyarakat')->with('success', 'Data Masyarakat Berhasil Diubah!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Masyarakat  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($nik)
    {
        Masyarakat::where('nik', $nik)->delete();

        return redirect('/data-masyarakat')->with('success', 'Data Masyarakat telah dihapus');

    }
}
