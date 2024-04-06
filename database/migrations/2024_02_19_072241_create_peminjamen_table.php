<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id('peminjamanid');
            $table->integer('userid');
            $table->integer('bukuid');
            $table->dateTime('tanggalpeminjaman');
            $table->dateTime('tanggalpengembalian')->nullable();
            $table->enum('statuspeminjaman', ['p','a','m','s'])->default('p');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
