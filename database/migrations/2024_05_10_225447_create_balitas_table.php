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
        Schema::create('balitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->date("TTL");
            $table->integer('age')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('ayah');
            $table->string('ibu');
            $table->foreignId('dusun_id')->constrained('dusuns')->cascadeOnDelete();
            $table->date("HPHTB");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balitas');
    }
};
