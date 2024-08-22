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
        Schema::create('periksalansias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->cascadeOnDelete();
            $table->string('lansia_nik')->nullable();
            $table->string('BB');
            $table->string('TB');
            $table->string('LP')->nullable();
            // $table->string('TD');
            $table->string('TDSI');
            $table->string('TDDI');
            $table->string('nadi')->nullable();
            $table->string('GD')->nullable();
            $table->string('AS')->nullable();
            $table->string('CHOL')->nullable();
            $table->string('GEP')->nullable();
            $table->string('SGDS')->nullable();
            $table->string('koghnitif')->nullable();
            $table->string('AMT')->nullable();
            $table->string('RJ')->nullable();
            $table->string('ADL')->nullable();
            $table->enum('kemandirian', ['A', 'B', 'C'])->nullable();
            $table->string('kencing')->nullable();
            $table->string('mata')->nullable();
            $table->string('telinga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksalansias');
    }
};
