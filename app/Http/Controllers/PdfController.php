<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'tanggalpeminjaman'=>'required',
            'tanggalpengembalian'=>'required',
        ]);

        $data = [
            'judul' => $request->judul,
            'tanggalpeminjaman' => $request->tanggalpeminjaman,
            'tanggalpengembalian' => $request->tanggalpengembalian,
        ];
        $pdf = Pdf::loadView('user.pdf.generate', $data);
        return $pdf->download('generatelaporan.pdf');
    }
}
