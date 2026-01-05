<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang'; // ⬅️ PENTING

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'stok',
        'harga',
        'foto',
        'lokasi',
    ];
}
