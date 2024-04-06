<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;
use App\Models\buku;

class koleksipribadi extends Model
{
    protected $fillable = ['userid','bukuid'];
    protected $primaryKey = 'koleksiid';

    public function user() {
        return $this->belongsTo(user::class, 'userid');
    }

    public function buku() {
        return $this->belongsTo(buku::class, 'bukuid');
    }
    use HasFactory;
}
