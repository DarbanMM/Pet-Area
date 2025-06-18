<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'symptoms',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
    ];

    // Relasi: Rekam medis dimiliki oleh satu pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi: Rekam medis dicatat oleh satu dokter
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}