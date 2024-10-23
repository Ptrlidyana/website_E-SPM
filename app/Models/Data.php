<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi penamaan Laravel,
    // Anda bisa mendefinisikan nama tabel secara eksplisit.
    protected $table = 'data'; // Ganti dengan nama tabel Anda jika berbeda

    protected $fillable = [
        'nomer_polisi',
        'volume',
        'nama_sopir',
        // Tambahkan field lain sesuai kebutuhan
    ];
}
