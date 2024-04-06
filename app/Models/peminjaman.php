<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    protected $fillable = ['id','bukuid','tanggalpeminjaman','tanggalpengembalian','statuspeminjaman'];
    
    protected $primaryKey = 'peminjamanid';

    public function user() {
        return $this->belongsTo(user::class, 'id');
    }

    public function buku() {
        return $this->belongsTo(buku::class, 'bukuid');
    }

    use HasFactory;
}
