<?php

namespace App\Http\Controllers;

use App\Models\kategoribuku;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = kategoribuku::all();
        return view('admin.tables.datakategori', compact('data'));
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
        $request->validate([
            'namakategori'=>'required'
        ]);

        kategoribuku::insert([
            'namakategori'=>$request->namakategori
        ]);

        return redirect('admin/kategori')->with('Success', 'Menambah Kategori Berhasil \^-^/');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        kategoribuku::where('kategoriid', $id)->delete();
        return redirect('admin/kategori')->with('delete', 'Kategori Sudah Terhapus');
    }
}
