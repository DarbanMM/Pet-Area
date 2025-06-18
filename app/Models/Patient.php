<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'date_of_birth',
        'gender',
        'weight',
        'medical_history',
        'owner_name',
        'owner_phone',
        'owner_address',
        'owner_email',
    ];

    // Relasi: Pasien memiliki banyak rekam medis
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // Relasi: Pasien memiliki banyak kunjungan
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // Relasi: Pasien bisa memiliki banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}