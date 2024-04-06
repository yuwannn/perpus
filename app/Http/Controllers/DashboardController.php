<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\adminpetugas;
use App\Models\buku;
use App\Models\kategoribuku;

class DashboardController extends Controller
{
    public function admindashboard () {
        $data = adminpetugas::all();
        return view('admin.dashboard.admin', ['data'=>$data]);
    }
}