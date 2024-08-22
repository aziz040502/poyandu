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
        Schema::create('periksabalitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('balitas')->cascadeOnDelete();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('usia')->nullable();
            $table->string('status')->nullable();
            $table->string('balita_nik')->nullable();
            $table->string('BB');
            $table->string('TB');
            $table->string('lila');
            $table->boolean('menyusuidini')->default(false);
            $table->string('lika');
            $table->text('rujukan')->nullable();
            $table->string('imunisasi')->nullable();
            $table->string('PMTpemulihan')->nullable();
            $table->enum("vitamin", ["vitamin A", "vitamin B", "vitamin M",])->nullable();
            $table->string('obatcacing')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksabalitas');
    }
};
