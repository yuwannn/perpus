<?php

namespace App\Http\Controllers;

use App\Models\koleksipribadi;
use Illuminate\Http\Request;
use App\Models\peminjaman;
// use PhpOffice\PhpWord\IOFactory;
// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\TemplateProcessor;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = peminjaman::all();
        return view('admin.tables.datapeminjaman', ['data' => $data]);
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
        //
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
        $request->validate([
            'statuspeminjaman' => 'required'
        ]);

        $tanggalPeminjaman = now();
        $tanggalPengembalian = $tanggalPeminjaman->copy()->addWeek();

        $peminjaman = [
            'statuspeminjaman' => $request->statuspeminjaman,
            'tanggalpeminjaman' => $tanggalPeminjaman,
            'tanggalpengembalian' => $tanggalPengembalian
        ];

        peminjaman::where('peminjamanid', $id)->update($peminjaman);

        session()->flash('notification', 'Status Peminjaman Anda Sudah Diperbarui');

        // Kode Pemberitahuan Selesai Update
        $peminjaman = peminjaman::find($id);
        $peminjaman->statuspeminjaman = $request->statuspeminjaman;
        $peminjaman->save();

        return redirect('admin/peminjaman')->with('status', 'Status Terupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
