<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class ulasanbuku extends Model
{
    protected $fillable = ['ulasanid','userid','bukuid','ulasan','rating'];

    public function user() {
        return $this->belongsTo(user::class, 'userid');
    }

    public function buku() {
        return $this->belongsTo(buku::class, 'bukuid');
    }

    use HasFactory;
}
