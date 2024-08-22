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
        Schema::create('ibuhamils', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('suami');
            $table->string('nik');
            $table->date("TTL");
            $table->foreignId('dusun_id')->constrained('dusuns')->cascadeOnDelete();
            $table->date("HPHTB")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibuhamils');
    }
};
