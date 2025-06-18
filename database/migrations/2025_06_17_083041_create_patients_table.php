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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama hewan
            $table->string('species'); // Jenis hewan (misal: Anjing, Kucing, Burung)
            $table->string('breed')->nullable(); // Ras hewan (misal: Golden Retriever, Persia)
            $table->date('date_of_birth')->nullable(); // Tanggal lahir
            $table->string('gender')->nullable(); // Jenis kelamin
            $table->decimal('weight', 8, 2)->nullable(); // Berat (misal: kg)
            $table->text('medical_history')->nullable(); // Riwayat kesehatan umum

            $table->string('owner_name'); // Nama pemilik
            $table->string('owner_phone')->nullable(); // No. HP pemilik
            $table->string('owner_address')->nullable(); // Alamat pemilik
            $table->string('owner_email')->nullable(); // Email pemilik

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};