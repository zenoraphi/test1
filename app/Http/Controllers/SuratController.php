<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dudi;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class SuratController extends Controller
{
    public function index()
    {
        return view('surat.index');
    }

    public function penjajakan()
    {
        $jurusans = Jurusan::orderBy('jurusan')->get();
        $dudis = Dudi::orderBy('nama')->get();
        return view('surat.penjajakan', compact('jurusans', 'dudis'));
    }

    public function penjajakanPreview(Request $request)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'nomor_surat' => 'required|string',
            'nama_dudi' => 'required|string',
            'alamat_dudi' => 'required|string',
            'lama_pkl' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'tingkat' => 'required|string',
            'jurusan' => 'required|string',
        ]);

        try {
            // Format tanggal
            Carbon::setLocale('id');
            
            $tanggalSurat = Carbon::parse($validated['tanggal_surat'])->translatedFormat('d F Y');
            $tanggalMulai = Carbon::parse($validated['tanggal_mulai'])->translatedFormat('d F Y');
            $tanggalSelesai = Carbon::parse($validated['tanggal_selesai'])->translatedFormat('d F Y');

            // Pecah alamat DUDI
            $alamatParts = explode(',', $validated['alamat_dudi']);
            $alamatJalan = trim($alamatParts[0] ?? $validated['alamat_dudi']);
            $alamatKecamatan = trim($alamatParts[1] ?? '');

            // Generate filename
            $timestamp = time();
            $random = Str::random(8);
            $baseFilename = "surat_penjajakan_{$timestamp}_{$random}";
            $tempDir = storage_path('app/temp');
            
            // Buat folder temp jika belum ada
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true);
            }

            // Template paths
            $templatePath = storage_path('app/templates/surat_penjajakan/surat-penjajakan-template.docx');
            $lampiranPath = storage_path('app/templates/surat_penjajakan/lampiran.docx');
            
            // Cek template
            if (!file_exists($templatePath) || !file_exists($lampiranPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Template tidak ditemukan'
                ], 404);
            }

            // Python script path
            $pythonScript = base_path('scripts/surat_penjajakan.py');
            
            if (!file_exists($pythonScript)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Script generator tidak ditemukan'
                ], 500);
            }

            // Build Python command (untuk Windows)
            $outputBasePath = $tempDir . '\\' . $baseFilename;
            
            $command = sprintf(
                'python "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s" "%s"',
                $pythonScript,
                $templatePath,
                $lampiranPath,
                $outputBasePath,
                $tanggalSurat,
                $validated['nomor_surat'],
                $validated['nama_dudi'],
                $alamatJalan,
                $alamatKecamatan,
                $validated['lama_pkl'],
                $tanggalMulai,
                $tanggalSelesai,
                $validated['tingkat'],
                $validated['jurusan']
            );

            // Execute Python
            $output = [];
            $returnVar = 0;
            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                \Log::error('Python error: ' . implode("\n", $output));
                
                // Fallback: copy template langsung
                $docxPath = $outputBasePath . '.docx';
                if (copy($templatePath, $docxPath) && file_exists($docxPath)) {
                    return response()->json([
                        'success' => true,
                        'filename' => basename($docxPath),
                        'url' => route('surat.temp.serve', ['filename' => basename($docxPath)]),
                        'type' => 'docx',
                        'warning' => 'Menggunakan template dasar (Python gagal)'
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat surat'
                ], 500);
            }

            // Cek file hasil
            $pdfPath = $outputBasePath . '.pdf';
            $docxPath = $outputBasePath . '.docx';
            
            if (file_exists($pdfPath)) {
                return response()->json([
                    'success' => true,
                    'filename' => basename($pdfPath),
                    'url' => route('surat.temp.serve', ['filename' => basename($pdfPath)]),
                    'type' => 'pdf'
                ]);
            }
            
            if (file_exists($docxPath)) {
                return response()->json([
                    'success' => true,
                    'filename' => basename($docxPath),
                    'url' => route('surat.temp.serve', ['filename' => basename($docxPath)]),
                    'type' => 'docx',
                    'warning' => 'PDF tidak tersedia, menampilkan DOCX'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'File hasil tidak ditemukan'
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Preview error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    /**
     * Tampilkan file untuk preview (FIXED VERSION)
     */
    public function serveTemp($filename)
    {
        try {
            $tempDir = storage_path('app/temp');
            $filePath = $tempDir . '/' . $filename;
            
            // Cek file langsung
            if (!file_exists($filePath)) {
                // Jika tidak ada dengan nama persis, cari file dengan pattern yang sama
                $files = scandir($tempDir);
                $foundFile = null;
                
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        // Cek apakah filename ada dalam nama file
                        if (strpos($file, $filename) !== false) {
                            $foundFile = $file;
                            break;
                        }
                    }
                }
                
                if ($foundFile) {
                    $filePath = $tempDir . '/' . $foundFile;
                } else {
                    // Tampilkan halaman 404 Laravel normal
                    abort(404, 'File tidak ditemukan');
                }
            }
            
            // Tentukan content type
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeTypes = [
                'pdf' => 'application/pdf',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
            
            $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';
            
            // Untuk DOCX, kita tidak bisa preview langsung di browser
            // Redirect ke download atau tampilkan pesan
            if ($extension === 'docx') {
                return response()->download(
                    $filePath, 
                    'surat_penjajakan.docx',
                    ['Content-Type' => $contentType]
                );
            }
            
            // Untuk PDF, tampilkan inline
            return response()->file($filePath, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Serve temp error: ' . $e->getMessage());
            abort(500, 'Gagal menampilkan file');
        }
    }

    /**
     * Download file
     */
    public function download(Request $request)
    {
    $validated = $request->validate([
        'filename' => 'required|string',
        'format' => 'required|in:pdf,docx'
    ]);

    $tempDir = storage_path('app/temp');
    
    // Cari file
    $baseName = $validated['filename'];
    if (!str_contains($baseName, '.')) {
        $baseName .= '.' . $validated['format'];
    }
    
    $filePath = $tempDir . '/' . $baseName;

    if (!file_exists($filePath)) {
        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan'
        ], 404);
    }

    $downloadName = 'Surat_Penjajakan_PKL_' . date('Y-m-d') . '.' . $validated['format'];

    // Hapus file setelah didownload
    $callback = function() use ($filePath) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    };

    // Dengan menggunakan afterResponse, file akan dihapus setelah response dikirim
    return response()->download($filePath, $downloadName)->afterResponse($callback);
    }

    /**
     * API: Get DUDI data
     */
    public function getDudi($id)
    {
        try {
            $dudi = Dudi::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $dudi->nama,
                    'alamat' => $dudi->alamat,
                    'pimpinan' => $dudi->pimpinan,
                    'pembimbing_dudi' => $dudi->pembimbing_dudi
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'DUDI tidak ditemukan'
            ], 404);
        }
    }
}