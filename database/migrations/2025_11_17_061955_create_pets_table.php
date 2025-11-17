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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();

            // relasi ke owners
            $table->foreignId('owner_id')
                ->constrained('owners')
                ->cascadeOnDelete();

            // kode hewan unik: HHMMXXXXYYYY
            $table->string('code', 20)->unique();

            // nama & jenis hewan (akan kita simpan dalam UPPERCASE di layer code)
            $table->string('name');
            $table->string('type'); // misal: KUCING, ANJING

            // usia (tahun) dan berat (kg)
            $table->unsignedInteger('age')->nullable();          // contoh: 2
            $table->decimal('weight', 5, 2)->nullable();         // contoh: 4.50

            // menyimpan input mentah, misal: "Milo Kucing 2Th 4.5kg"
            $table->string('raw_input')->nullable();

            $table->timestamps();

            // 1 owner tidak boleh punya hewan dengan kombinasi nama + jenis yang sama
            $table->unique(['owner_id', 'name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
