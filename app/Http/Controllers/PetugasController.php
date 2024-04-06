<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\adminpetugas;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = adminpetugas::all();
        return view('admin.tables.datapetugas', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $passwordhashed = Hash::make($request->password);

        adminpetugas::insert([
            'nama' => $request->nama,
            'password' => $passwordhashed,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat
        ]);

        return redirect('DataPegawai')->with('Success', 'Tambah Data Petugas Berhasil \^-^/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'nama'=>'required',
            'username'=>'required',
            'password'=>'required',
            'email'=> ['required', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'alamat'=>'required'
        ]);

        $passwordhashed = Hash::make($request->password);
        $petugas = [
            'nama'=>$request->nama,
            'username'=>$request->username,
            'password'=>$passwordhashed,
            'email'=>$request->email,
            'alamat'=>$request->alamat
        ];

        adminpetugas::where('id', $id)->update($petugas);
        return redirect('admin/DataPegawai')->with('editsuccess', 'Edit Data Petugas Berhasil ^=^');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        adminpetugas::where('id', $id)->delete();
        return redirect()->route('DataPegawai.index')->with('delete', 'Data Petugas Telah Dihapus :(');
    }
}
