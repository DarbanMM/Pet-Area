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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang mencatat kunjungan

            $table->date('visit_date');
            $table->string('purpose')->nullable(); // Tujuan kunjungan (misal: Vaksin, Cek Up, Periksa Sakit)
            $table->string('status')->default('pending'); // Status kunjungan (misal: pending, completed, canceled)
            $table->text('notes')->nullable(); // Catatan admin saat pendaftaran/kedatangan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};