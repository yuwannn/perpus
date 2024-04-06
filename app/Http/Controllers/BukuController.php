<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\buku;
use App\Models\peminjaman;
use App\Models\koleksipribadi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\kategoribuku;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function kategori(string $id)
    {
        $categories = kategoribuku::where('kategoriid', $id)->get();
        $data = buku::all()->where('kategori', $id);
        return view('admin.tables.databuku', compact('data', 'categories'));
    }

    public function index()
    {
        return view('admin.tables.databuku', [
            'data' => buku::all(),
            'categories' => kategoribuku::all()
        ]);
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
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunterbit' => 'required',
            'sinopsis' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $imageName = time() . '.' . $request->cover->extension();
        $request->cover->move(public_path('asset/images/cover'), $imageName);

        buku::insert([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahunterbit' => $request->tahunterbit,
            'sinopsis' => $request->sinopsis,
            'kategori' => $request->kategori,
            'cover' => $imageName,
            'stok' => $request->stok,
            'created_at' => now()
        ]);

        return redirect()->route('buku.index')->with('Success', 'Tambah Buku Berhasil \^-^/');
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
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunterbit' => 'required',
            'sinopsis' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'
        ]);

        // Temukan buku yang akan diperbarui
        $buku = buku::where('bukuid', $id)->FirstOrFail();

        // Jika ada file cover baru diunggah
        if ($request->hasFile('cover')) {
            // Hapus cover lama
            if (File::exists(public_path('asset/images/cover/' . $buku->cover))) {
                File::delete(public_path('asset/images/cover/' . $buku->cover));
            }

            // Simpan file cover baru
            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('asset/images/cover'), $imageName);

            // Update nama file cover baru
            $buku->cover = $imageName;
        }

        // Update informasi buku
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahunterbit = $request->tahunterbit;
        $buku->sinopsis = $request->sinopsis;
        $buku->updated_at = now();
        $buku->save();

        return redirect()->route('buku.index')->with('editsuccess', 'Edit Data Buku Berhasil ^=^');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = buku::where('bukuid', $id)->first();

        if (File::exists(public_path('asset/images/cover/' . $buku->cover))) {
            File::delete(public_path('asset/images/cover/' . $buku->cover));
        };

        $buku->delete();

        return redirect()->route('buku.index')->with('delete', 'Buku Telah Dihapus :(');
    }


    public function peminjamanbuku(Request $request, string $id)
    {

        // Validasi data yang diterima
        $request->validate([
            'bukuid' => 'required',
            'judul' => 'required',
        ]);

        // Dapatkan ID User yang sedang Login
        $userid = Auth::id();

        // Periksa Apakah Pengguna Sudah Pinjam Buku Ini Sebelumnya
        $existingPeminjam = peminjaman::where('userid', $userid)->where('bukuid', $request->bukuid)->exists();

        if ($existingPeminjam) {
            return redirect()->route('user.buku.blog')->with('gagalpinjam', 'Maaf, Kembalikan Buku Yang Sudah Anda Pinjam Terlebih Dahulu');
        }

        // Menghitung tanggal pengembalian (1 minggu setelah meminjam)
        $tanggalPeminjaman = now();

        // Menyimpan Data ke Database
        peminjaman::insert([
            'userid' => $userid,
            'bukuid' => $request->bukuid,
            'tanggalpeminjaman' => $tanggalPeminjaman,
            'statuspeminjaman' => 'p', // Status default saat meminjam
        ]);

        $buku = buku::find($id);

        // Validasi stok buku
        if ($buku->stok < $request->input('stok')) {
            return redirect()->route('user.buku.blog')->with('gagalpinjam', 'Maaf Stok Buku Tidak Tersedia');
        }

        // Kurangin stok
        $buku->stok -= $request->input('stok');
        $buku->save();

        // return response()->download($filename);
        return redirect()->route('user.buku.blog')->with('berhasilpinjam', 'Terimakasih, buku yang ingin anda pinjam akan segera di proses, tunggu hinggal admin selesai mengurusnya ^--^');
    }
}
