<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom default_role dengan tipe data yang sesuai
            $table->foreignId('default_role')->nullable();

            // Buat relasi antara default_role dengan id di tabel roles
            $table->foreign('default_role')->references('id')->on('roles')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus relasi default_role terlebih dahulu
            $table->dropForeign(['default_role']);

            // Kemudian hapus kolom default_role
            $table->dropColumn('default_role');
        });
    }
};
