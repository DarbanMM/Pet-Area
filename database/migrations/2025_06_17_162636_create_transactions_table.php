<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_transactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->foreignId('admin_id')->constrained('users'); // user with 'admin' role
            $table->date('transaction_date');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('status')->default('completed'); // completed, pending, canceled
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transactions'); }
};