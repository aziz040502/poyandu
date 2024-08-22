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
        Schema::create('periksaibuhamils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibuhamil_id')->constrained('ibu_hamils')->cascadeOnDelete();
            $table->date('HPHT')->nullable();
            $table->string('UK');
            $table->date('PTP')->nullable();
            $table->string('BB');
            $table->string('TB');
            $table->string('lila');
            $table->string('TDSI');
            $table->string('TDDI');
            $table->string('TFU')->nullable();
            $table->string('DJJ')->nullable();
            $table->string('LJ')->nullable();
            $table->string('HB')->nullable();
            $table->string('GDS')->nullable();
            $table->string('PU')->nullable();
            $table->string('TT')->nullable();
            $table->string('TTD')->nullable();
            $table->string('PMTpemulihan')->nullable();
            $table->string('rujukan')->nullable();
            $table->boolean('bukuKIA')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksaibuhamils');
    }
};
