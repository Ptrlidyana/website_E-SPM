<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Karyawan;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Imports\KaryawanImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Schema\Blueprint;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Migrations\Migration;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Validator;



class DashboardController extends Controller
{
  public function index()
  {
    // Logika untuk menampilkan dashboard admin
    return view('admin.dashboard'); // Ganti dengan nama view yang sesuai
  }
}
class KaryawanController extends Controller
{
  public function index()
  {
    $karyawans = Karyawan::where('is_deleted', false)->get();
    return view('admin.tampilan', compact('karyawans'));
  }



  public function exportExcelAll()
  {
    $karyawanData = Karyawan::all();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    $sheet->setCellValue('A1', 'DATA KENDARAAN PUPUK CAIR SARITANA');
    $sheet->mergeCells('A1:H1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


    $headers = ['No', 'Nomer Polisi', 'Volume', 'Nama Sopir', 'Tanggal', 'Bukti Timbang', 'Bukti Truck'];
    $columnLetter = 'A';

    foreach ($headers as $header) {
      $sheet->setCellValue($columnLetter . '3', $header);
      $sheet->getStyle($columnLetter . '3')->getFont()->setBold(true);
      $sheet->getStyle($columnLetter . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle($columnLetter . '3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle($columnLetter . '3')->getFill()->getStartColor()->setARGB('FFD3D3D3');
      $columnLetter++;
    }


    $row = 4;
    $no = 1;
    foreach ($karyawanData as $data) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $data->nomer_polisi);
      $sheet->setCellValue('C' . $row, $data->volume);
      $sheet->setCellValue('D' . $row, $data->nama_user);
      $sheet->setCellValue('E' . $row, $data->tanggal);


      $fullPath1 = public_path('storage/' . $data->file_upload);
      if (file_exists($fullPath1)) {
        $drawing1 = new Drawing();
        $drawing1->setName('Bukti Timbang');
        $drawing1->setDescription('Bukti Timbang');
        $drawing1->setPath($fullPath1);
        $drawing1->setWidth(150);
        $drawing1->setHeight(90);
        $drawing1->setCoordinates('F' . $row);
        $drawing1->setOffsetX(5);
        $drawing1->setOffsetY(5);
        $drawing1->setWorksheet($sheet);
      }


      $fullPath2 = public_path('storage/' . $data->second_file_upload);
      if (file_exists($fullPath2)) {
        $drawing2 = new Drawing();
        $drawing2->setName('Bukti Truck');
        $drawing2->setDescription('Bukti Truck');
        $drawing2->setPath($fullPath2);
        $drawing2->setWidth(100);
        $drawing2->setHeight(70);
        $drawing2->setCoordinates('G' . $row);
        $drawing2->setOffsetX(5);
        $drawing2->setOffsetY(5);
        $drawing2->setWorksheet($sheet);
      }

      $row++;
      $no++;
    }


    for ($i = 4; $i < $row; $i++) {
      $sheet->getRowDimension($i)->setRowHeight(60);
    }


    foreach (range('A', 'F') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }


    $sheet->getColumnDimension('G')->setWidth(25);

    $fileName = 'All Data Transportir.xlsx';
    if (ob_get_length()) ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save("php://output");
    exit();
  }


  public function exportExcel(Request $request)
  {

    $request->validate([
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
    ]);


    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');


    $karyawanData = Karyawan::whereBetween('tanggal', [$startDate, $endDate])->get();


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    $sheet->setCellValue('A1', 'DATA KENDARAAN PUPUK CAIR SARITANA');
    $sheet->mergeCells('A1:H1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


    $headers = ['No', 'Nomer Polisi', 'Volume', 'Nama Sopir', 'Tanggal', 'Bukti Timbang', 'Bukti Truck'];
    $columnLetter = 'A';

    foreach ($headers as $header) {
      $sheet->setCellValue($columnLetter . '3', $header);
      $sheet->getStyle($columnLetter . '3')->getFont()->setBold(true);
      $sheet->getStyle($columnLetter . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle($columnLetter . '3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle($columnLetter . '3')->getFill()->getStartColor()->setARGB('FFD3D3D3');
      $columnLetter++;
    }


    $row = 4;
    $no = 1;
    foreach ($karyawanData as $data) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $data->nomer_polisi);
      $sheet->setCellValue('C' . $row, $data->volume);
      $sheet->setCellValue('D' . $row, $data->nama_user);
      $sheet->setCellValue('E' . $row, $data->tanggal);


      $fullPath1 = public_path('storage/' . $data->file_upload);
      if (file_exists($fullPath1)) {
        $drawing1 = new Drawing();
        $drawing1->setName('Bukti Timbang');
        $drawing1->setDescription('Bukti Timbang');
        $drawing1->setPath($fullPath1);
        $drawing1->setWidth(150);
        $drawing1->setHeight(90);
        $drawing1->setCoordinates('F' . $row);
        $drawing1->setOffsetX(5);
        $drawing1->setOffsetY(5);
        $drawing1->setWorksheet($sheet);
      }


      $fullPath2 = public_path('storage/' . $data->second_file_upload);
      if (file_exists($fullPath2)) {
        $drawing2 = new Drawing();
        $drawing2->setName('Bukti Truck');
        $drawing2->setDescription('Bukti Truck');
        $drawing2->setPath($fullPath2);
        $drawing2->setWidth(150);
        $drawing2->setHeight(90);
        $drawing2->setCoordinates('G' . $row);
        $drawing2->setOffsetX(5);
        $drawing2->setOffsetY(5);
        $drawing2->setWorksheet($sheet);
      }

      $row++;
      $no++;
    }

    for ($i = 4; $i < $row; $i++) {
      $sheet->getRowDimension($i)->setRowHeight(90);
    }

    foreach (range('A', 'F') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }


    $sheet->getColumnDimension('G')->setWidth(25);


    $formattedStartDate = \Carbon\Carbon::parse($startDate)->format('d-m-Y');
    $formattedEndDate = \Carbon\Carbon::parse($endDate)->format('d-m-Y');


    $fileName = 'Data Transportir ' . $formattedStartDate . ' - ' . $formattedEndDate . '.xlsx';

    if (ob_get_length()) ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save("php://output");
    exit();
  }



  public function search(Request $request)
  {
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');


    $karyawans = Karyawan::whereBetween('tanggal', [$fromDate, $toDate])->get();


    return view('admin.tampilan', compact('karyawans'));
  }
  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'no_po' => 'required|string',
      'tanggal' => 'required|date',
      'nomer_polisi' => 'required|string',
      'volume' => 'required|numeric',
      'nama_transportir' => 'required|string',
      'nama_user' => 'required|string',
      'file_upload' => 'required|file|mimes:jpg,png,pdf|max:2048', // sesuaikan dengan tipe file yang diterima
      'second_file_upload' => 'required|file|mimes:jpg,png,pdf|max:2048', // sesuaikan dengan tipe file yang diterima
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $karyawan = Karyawan::findOrFail($id);


    if ($request->hasFile('file_upload')) {
      if ($karyawan->file_upload) {
        Storage::disk('public')->delete($karyawan->file_upload);
      }
      $filePath1 = $request->file('file_upload')->store('uploads', 'public');
    } else {
      $filePath1 = $karyawan->file_upload;
    }

    if ($request->hasFile('second_file_upload')) {
      if ($karyawan->second_file_upload) {
        Storage::disk('public')->delete($karyawan->second_file_upload);
      }
      $filePath2 = $request->file('second_file_upload')->store('uploads', 'public');
    } else {
      $filePath2 = $karyawan->second_file_upload;
    }


    $karyawan->update([
      'no_po' => $validated['no_po'],
      'tanggal' => $validated['tanggal'],
      'nomer_polisi' => $validated['nomer_polisi'],
      'volume' => $validated['volume'],
      'nama_transportir' => $validated['nama_transportir'],
      'nama_user' => $validated['nama_user'],
      'file_upload' => $filePath1,
      'second_file_upload' => $filePath2,
    ]);

    return redirect()->route('dashboard')->with('success', 'Data berhasil diperbarui!');
  }
  // public function store(Request $request)
  // {
  //   $validated = $request->validate([
  //     'no_po' => 'required|string|max:255',
  //     'tanggal' => 'required|date',
  //     'nomer_polisi' => 'required|string|max:255',
  //     'volume' => 'required',
  //     'nama_transportir' => 'required|string|max:255',
  //     'nama_user' => 'required|string|max:255',
  //     'file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
  //     'second_file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
  //   ]);


  //   $fileUploadPath = $request->hasFile('file_upload') ? $request->file('file_upload')->store('uploads', 'public') : null;
  //   $secondFileUploadPath = $request->hasFile('second_file_upload') ? $request->file('second_file_upload')->store('uploads', 'public') : null;


  //   Karyawan::create([
  //     'no_po' => $validated['no_po'],
  //     'tanggal' => $validated['tanggal'],
  //     'nomer_polisi' => $validated['nomer_polisi'],
  //     'volume' => $validated['volume'],
  //     'nama_transportir' => $validated['nama_transportir'],
  //     'nama_user' => $validated['nama_user'],
  //     'file_upload' => $fileUploadPath,
  //     'second_file_upload' => $secondFileUploadPath,
  //   ]);


  //   session()->flash('success', 'Data berhasil disimpan!');

  //   return back()->with('success', 'Data berhasil disimpan.');
  // }

  public function store(Request $request)
  {
      // Validasi input
      $validated = $request->validate([
          'no_po' => 'required|string|max:255',
          'tanggal' => 'required|date',
          'nomer_polisi' => 'required|string|max:255',
          'volume' => 'required',
          'nama_transportir' => 'required|string|max:255',
          'nama_user' => 'required|string|max:255',
          'file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
          'second_file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
      ]);
  
      $existingPo = Karyawan::where('no_po', $validated['no_po'])->first();
  
      if ($existingPo) {
          return back()->withErrors(['no_po' => 'Nomor PO anda telah terdaftar!'])->withInput();
      }
  
      // Upload file jika ada
      $fileUploadPath = $request->hasFile('file_upload') ? $request->file('file_upload')->store('uploads', 'public') : null;
      $secondFileUploadPath = $request->hasFile('second_file_upload') ? $request->file('second_file_upload')->store('uploads', 'public') : null;
  
      // Simpan data baru
      Karyawan::create([
          'no_po' => $validated['no_po'],
          'tanggal' => $validated['tanggal'],
          'nomer_polisi' => $validated['nomer_polisi'],
          'volume' => $validated['volume'],
          'nama_transportir' => $validated['nama_transportir'],
          'nama_user' => $validated['nama_user'],
          'file_upload' => $fileUploadPath,
          'second_file_upload' => $secondFileUploadPath,
      ]);
  
      // Set flash message untuk notifikasi sukses
      session()->flash('success', 'Data berhasil disimpan!');
  
      return back()->with('success', 'Data berhasil disimpan.');
  }
  

  public function import(Request $request)
  {
    // Validasi file yang diunggah
    $request->validate([
      'file_excel' => 'required|mimes:xlsx,xls|max:2048',
    ]);

    // Mengimpor file Excel
    Excel::import(new KaryawanImport, $request->file('file_excel'));

    // Kembali ke halaman sebelumnya dengan notifikasi sukses
    return redirect()->back()->with('success', 'Data berhasil diimpor!');
  }

  public function permanentlyDelete($id)
  {

    $karyawan = Karyawan::withTrashed()->findOrFail($id);
    $karyawan->forceDelete();


    return redirect()->route('karyawan.trashed')->with('success', 'Data karyawan berhasil dihapus secara permanen.');
  }
  public function storeOrUpdateData(Request $request)
  {
      // Validasi data yang masuk
      // Validasi input form
      $validatedData = $request->validate([
        'nomer_polisi' => 'required|string|max:255',
        'volume' => 'required|numeric',
        'nama_sopir' => 'required|string|max:255',
    ]);
  
      // Cek apakah nomer_polisi sudah ada di database
      $existingData = Data::where('nomer_polisi', $validatedData['nomer_polisi'])->first();
  
      if ($existingData) {
          // Jika sudah ada, berikan notifikasi
          return redirect()->route('data.nomer')->with('error', 'Mohon maaf, data sudah ada.');
      }
  
      // Jika belum ada, simpan data baru
      Data::create($validatedData);
  
      // Redirect kembali dengan notifikasi
      return redirect()->route('data.nomer')->with('success', 'Data berhasil disimpan!');
  }
  
  public function softDelete($id)
  {
    $karyawan = Karyawan::findOrFail($id);
    $karyawan->is_deleted = true;
    $karyawan->save();

    return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus sementara.');
  }


  public function restore($id)
  {
    $karyawan = Karyawan::findOrFail($id);
    $karyawan->is_deleted = false;
    $karyawan->save();

    return redirect()->route('karyawan.index')->with('success', 'Data berhasil dikembalikan.');
  }


  public function trashed()
  {
    $karyawans = Karyawan::where('is_deleted', true)->get();
    return view('admin.trashed', compact('karyawans'));
  }


  public function cetakPdf($id)
  {
    $karyawan = Karyawan::findOrFail($id);
    $pdf = Pdf::loadView('admin.karyawan_pdf', compact('karyawan'));
    return $pdf->download('purchase_order_' . $karyawan->id . '.pdf');
  }
  public function create()
  {

    $nomerPolisiList = Data::select('nomer_polisi')->distinct()->get();


    return view('dashboard', compact('nomerPolisiList'));
  }
  public function getVolumes($nomer_polisi)
{
    // Mengambil data volume dan nama sopir berdasarkan nomer polisi
    $data = Data::where('nomer_polisi', $nomer_polisi)
                ->select('volume', 'nama_sopir') // pilih kolom volume dan nama_sopir
                ->first();

    // Pastikan ada data yang ditemukan
    if ($data) {
        return response()->json([
            'volume' => $data->volume,
            'nama_sopir' => $data->nama_sopir,
        ]);
    } else {
        return response()->json([
            'volume' => null,
            'nama_sopir' => null,
        ]);
    }
}


  public function showForm()
  {
    $nomerPolisiList = DB::table('data')->select('nomer_polisi')->distinct()->get();
    return view('dashboard', compact('nomerPolisiList'));
  }

  public function profile()
  {
    $user = Auth::user();
    return view('profile.index', compact('user'));
  }
  public function dataNomer()
  {
    $data = DB::table('data')->get();
    return view('admin.data-nomer', ['data' => $data]);
  }

  public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        // Get the uploaded file
        $file = $request->file('file');

        // Load the spreadsheet file using PhpSpreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the highest row and column numbers
        $highestRow = $worksheet->getHighestRow();

        $importData = [];

        // Iterate over rows, skipping the first (header) row
        for ($row = 2; $row <= $highestRow; $row++) {
            $noPol = $worksheet->getCell('B' . $row)->getValue();
            $vol = $worksheet->getCell('C' . $row)->getValue();
            $sopir = $worksheet->getCell('D' . $row)->getValue();

            $vol = trim($vol); // Remove any extra spaces
            $vol = str_replace(',', '.', $vol); // Replace comma with dot for decimal
            $vol = is_numeric($vol) ? (float)$vol : 0; // Convert to float if numeric, otherwise set to 0

            // Ensure that required fields are present
            if ((!empty($noPol) && !empty($vol) && !empty($sopir)) && ($noPol !== 'NoPol' && $vol !== 'Vol' && $sopir !== 'Sopir')) {
                // Cek apakah nomor polisi sudah ada di database
                $exists = DB::table('data')->where('nomer_polisi', $noPol)->exists();

                // Jika nomor polisi belum ada, tambahkan ke array data untuk diimport
                if (!$exists) {
                    $importData[] = [
                        'nomer_polisi' => $noPol,
                        'volume' => $vol,
                        'nama_sopir' => $sopir,
                    ];
                }
            }
        }

        // Insert data in a transaction
        if (!empty($importData)) {
            DB::transaction(function () use ($importData) {
                DB::table('data')->insert($importData);
            });
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data berhasil diimport, dengan pengecualian nomor polisi yang sudah ada.');
    } catch (\Exception $e) {
        // Log error and return error message
        // Log::error("Kesalahan saat mengimpor data: " . $e->getMessage());
        return redirect()->back()->with('error', 'Kesalahan saat mengimpor data: ' . $e->getMessage());
    }
}

  public function updateData(Request $request, $id)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nomer_polisi' => 'required|string|max:255',
        'volume' => 'required',
        'nama_sopir' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = Data::find($id); 

    if ($data) {
        $data->nomer_polisi = $request->input('nomer_polisi');
        $data->volume = $request->input('volume');
        $data->nama_sopir = $request->input('nama_sopir');
        // Simpan perubahan
        $data->save(); 

        // Set session status
        session()->flash('status', 'Selamat! Data anda berhasil disimpan.');
        
        // Kembalikan response untuk reload
        return response()->json(['success' => true]);
    }

    return response()->json(['message' => 'Data tidak ditemukan.'], 404);
}
public function showData()
{
    $datas = Data::all();
    dd($datas); // Tambahkan ini untuk debugging
    return view('data.index', compact('datas'));
}


public function destroy($id)
{
    // Temukan data berdasarkan ID
    $data = Data::findOrFail($id);

    // Hapus data
    $data->delete();

    // Redirect ke halaman data-nomer dengan notifikasi sukses
    return redirect()->route('data.nomer')->with('success', 'Data berhasil dihapus!');
}




}