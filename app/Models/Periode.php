<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periode extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'status'];

    // Relasi: Satu periode punya banyak transaksi kas
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
