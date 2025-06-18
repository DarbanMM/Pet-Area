<?php
// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'admin_id',
        'transaction_date',
        'description',
        'amount',
        'payment_method',
        'status',
    ];

    // Relasi: Transaksi bisa terkait dengan satu pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi: Transaksi dicatat oleh satu admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}