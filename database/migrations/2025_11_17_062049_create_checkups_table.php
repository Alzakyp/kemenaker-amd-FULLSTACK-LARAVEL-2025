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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();

            // relasi hewan yang diperiksa
            $table->foreignId('pet_id')
                ->constrained('pets')
                ->cascadeOnDelete();

            // relasi jenis treatment
            $table->foreignId('treatment_id')
                ->constrained('treatments')
                ->restrictOnDelete();

            $table->date('checkup_date');                   // tanggal pemeriksaan
            $table->decimal('weight_at_checkup', 5, 2)->nullable(); // berat saat dicek
            $table->text('notes')->nullable();              // catatan dokter / diagnosa

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
