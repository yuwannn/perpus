<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoribuku extends Model
{
    use HasFactory;
    protected $fillable = ['namakategori'];
    protected $table = 'kategoribukus';
    public $timestamps = true;
}
