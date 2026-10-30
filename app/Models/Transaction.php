<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'type',
        'amount',
        'category',
        'description',
        // 'period_id',
        // 'user_id'
    ];

    // Relasi: Transaksi ini milik periode tertentu
    public function period()
    {
        return $this->belongsTo(Periode::class);
    }

    // Relasi: Transaksi ini di-input oleh admin (user) siapa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
