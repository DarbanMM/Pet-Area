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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // Link ke pasien
            $table->foreignId('doctor_id')->constrained('users'); // Link ke dokter (user dengan role 'dokter')

            $table->date('visit_date'); // Tanggal kunjungan
            $table->text('symptoms')->nullable(); // Gejala
            $table->text('diagnosis')->nullable(); // Diagnosis
            $table->text('treatment')->nullable(); // Tindakan/Perawatan
            $table->text('prescription')->nullable(); // Resep obat
            $table->text('notes')->nullable(); // Catatan tambahan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};