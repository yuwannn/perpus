<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\buku;
use App\Models\user;
use App\Models\kategoribuku;
use App\Models\koleksipribadi;
use App\Models\peminjaman;

class UserController extends Controller
{
    public function kategori (string $id) {
        $categories = kategoribuku::where('kategoriid', $id)->get();
        $data = buku::all()->where('kategori', $id);
        return view('user.buku.blogbuku', compact('data', 'categories'));
    }

    public function detailbuku () {
        return view('user.buku.detailbuku', [
            'data' => buku::all(),
            'categories' => kategoribuku::all()
        ]);
    }

    public function blog () {
        return view('user.buku.blogbuku', [
            'data' => buku::all(),
            'categories' => kategoribuku::all()
        ]);
    }

    public function peminjamanid(string $id) {
        $user = Auth::user();
        $buku = buku::where('bukuid',$id)->get();
        $data = peminjaman::where('userid',$user->id)->whereIn('bukuid',$buku->pluck('bukuid'))->get();

        return view('user.buku.koleksi', compact('user', 'buku', 'data'));
    }

    public function historypeminjaman() {
        // $user = Auth::user();
        // $data = peminjaman::where('userid',$user->id);

        return view('user.buku.history', [
            'user' => Auth::user(),
            'buku' => buku::all(),
            'data' => peminjaman::all()
        ]);
    }
}
