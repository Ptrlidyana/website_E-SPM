<?php

namespace App\Http\Controllers;

use App\Models\Karyawan; // Jangan lupa import model Karyawan

class HomeController extends Controller
{
  public function index()
  {
    // Ambil semua data dari tabel karyawans
    $karyawans = Karyawan::all();

    // Kirim data ke view admin/tampilan.blade.php
    return view('admin.tampilan', compact('karyawans'));
  }
}
