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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null'); // Transaksi bisa terkait pasien atau tidak
            $table->foreignId('admin_id')->constrained('users'); // Admin yang mencatat transaksi

            $table->date('transaction_date');
            $table->string('description'); // Deskripsi layanan/produk
            $table->decimal('amount', 10, 2); // Jumlah transaksi
            $table->string('payment_method')->nullable(); // Metode pembayaran
            $table->string('status')->default('completed'); // Status transaksi (completed, pending, canceled)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};