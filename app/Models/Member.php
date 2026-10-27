<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ← Pastikan use ini ada di paling atas
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory; // ← Tambahkan baris ini di dalam class

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'nomor_telepon',
        'alamat',
        'status',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}