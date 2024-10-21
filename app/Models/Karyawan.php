<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_po', 
        'tanggal', 
        'nomer_polisi', 
        'volume', 
        'nama_transportir', 
        'nama_user', 
        'file_upload', 
        'second_file_upload'
    ];
}
