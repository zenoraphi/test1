@extends('layouts.app')

@section('title', 'Buat Surat Penjajakan')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

<style>
    .select2-container--default .select2-selection--single {
        height: 44px !important;
        border-radius: 0.75rem !important;
        border: 2px solid #e5e7eb !important;
        padding: 0.5rem 1rem !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        padding-left: 0 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
        right: 10px !important;
    }
    
    .flatpickr-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%233b82f6'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 40px !important;
    }
</style>

{{-- HEADER --}}
<div class="mb-6 animate-slide-down">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-1">
                    <i class="fas fa-file-contract mr-3"></i>
                    Surat Penjajakan PKL
                </h1>
                <p class="text-white/80 text-sm">
                    Isi formulir untuk membuat surat penjajakan
                </p>
            </div>
            <a href="{{ route('surat.index') }}"
               class="bg-white text-primary px-5 py-3 rounded-xl shadow hover:bg-gray-100 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>

{{-- FORM --}}
<div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-scale-fade">
    <form id="suratForm" class="space-y-8">
        @csrf
        
        {{-- Informasi Surat --}}
        <div>
            <div class="border-l-4 border-primary pl-4 mb-6">
                <h3 class="text-xl font-bold text-gray-800">Informasi Surat</h3>
                <p class="text-gray-600 text-sm">Data identitas surat</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tanggal Surat --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-calendar-alt text-primary mr-2"></i>Tanggal Surat
                    </label>
                    <input type="text"
                           id="tanggal_surat"
                           name="tanggal_surat"
                           class="form-input flatpickr-input"
                           placeholder="Pilih tanggal surat"
                           required>
                </div>

                {{-- Nomor Surat --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-hashtag text-primary mr-2"></i>Nomor Surat
                    </label>
                    <input type="text"
                           name="nomor_surat"
                           class="form-input"
                           placeholder="Contoh: 123/PKL/2025"
                           required>
                </div>
            </div>
        </div>

        {{-- Informasi DUDI --}}
        <div>
            <div class="border-l-4 border-green-500 pl-4 mb-6">
                <h3 class="text-xl font-bold text-gray-800">Informasi DUDI</h3>
                <p class="text-gray-600 text-sm">Data perusahaan/instansi tujuan</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                {{-- Nama DUDI (Combobox) --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-building text-green-500 mr-2"></i>Nama DUDI
                    </label>
                    <select id="dudi_select"
                            name="nama_dudi"
                            class="form-input"
                            required>
                        <option value="">-- Pilih DUDI --</option>
                        @foreach($dudis as $dudi)
                            <option value="{{ $dudi->nama }}" data-id="{{ $dudi->id_dudi }}">
                                {{ $dudi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alamat DUDI (Auto-fill) --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>Alamat DUDI
                    </label>
                    <textarea id="alamat_dudi"
                              name="alamat_dudi"
                              rows="3"
                              class="form-input"
                              placeholder="Alamat akan terisi otomatis"
                              required></textarea>
                </div>
            </div>
        </div>

        {{-- Informasi PKL --}}
        <div>
            <div class="border-l-4 border-purple-500 pl-4 mb-6">
                <h3 class="text-xl font-bold text-gray-800">Informasi PKL</h3>
                <p class="text-gray-600 text-sm">Detail pelaksanaan PKL</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Lama PKL --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-clock text-purple-500 mr-2"></i>Lama PKL
                    </label>
                    <input type="text"
                           name="lama_pkl"
                           class="form-input"
                           placeholder="Contoh: 3 Bulan"
                           required>
                </div>

                {{-- Tingkat --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-layer-group text-purple-500 mr-2"></i>Tingkat Kelas
                    </label>
                    <select name="tingkat" class="form-input" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="XI">XI</option>
                        <option value="XII" selected>XII</option>
                        <option value="XIII">XIII</option>
                    </select>
                </div>

                {{-- Tanggal Mulai --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-calendar-check text-purple-500 mr-2"></i>Tanggal Mulai
                    </label>
                    <input type="text"
                           id="tanggal_mulai"
                           name="tanggal_mulai"
                           class="form-input flatpickr-input"
                           placeholder="Pilih tanggal mulai"
                           required>
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label class="block font-semibold mb-2">
                        <i class="fas fa-calendar-times text-purple-500 mr-2"></i>Tanggal Selesai
                    </label>
                    <input type="text"
                           id="tanggal_selesai"
                           name="tanggal_selesai"
                           class="form-input flatpickr-input"
                           placeholder="Pilih tanggal selesai"
                           required>
                </div>
            </div>

            {{-- Jurusan (Combobox) --}}
            <div class="mt-6">
                <label class="block font-semibold mb-2">
                    <i class="fas fa-graduation-cap text-purple-500 mr-2"></i>Jurusan
                </label>
                <select id="jurusan_select"
                        name="jurusan"
                        class="form-input"
                        required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->jurusan }}">{{ $jurusan->jurusan }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-gray-200">
            <button type="button"
                    onclick="document.getElementById('suratForm').reset(); dudiSelect.val(null).trigger('change'); jurusanSelect.val(null).trigger('change');"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-6 rounded-xl transition">
                <i class="fas fa-redo mr-2"></i>Reset Form
            </button>
            <button type="submit"
                    id="previewBtn"
                    class="flex-1 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-primary text-white font-semibold py-4 px-6 rounded-xl transition shadow-lg">
                <i class="fas fa-eye mr-2"></i>Preview Surat
            </button>
        </div>
    </form>
</div>

{{-- Preview Modal --}}
<div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-blue-600 p-6 text-white flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold">Preview Surat Penjajakan</h3>
                <p class="text-blue-100 mt-1">Periksa kembali sebelum mengunduh</p>
            </div>
            <button onclick="closePreview()" class="text-white hover:bg-blue-700 p-2 rounded-lg transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
            <div id="pdfPreview" class="w-full h-[600px] border-2 border-gray-300 rounded-lg overflow-hidden">
                <!-- PDF will be embedded here -->
            </div>
        </div>

        <div class="bg-gray-50 p-6 flex flex-col sm:flex-row gap-4 border-t-2">
            <button onclick="printSurat()"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
            <button onclick="downloadSurat('pdf')"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                <i class="fas fa-file-pdf mr-2"></i>Download PDF
            </button>
            <button onclick="downloadSurat('docx')"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                <i class="fas fa-file-word mr-2"></i>Download DOCX
            </button>
        </div>
    </div>
</div>

{{-- Loading Modal --}}
<div id="loadingModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-primary mx-auto mb-4"></div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Memproses Surat...</h3>
        <p class="text-gray-600">Mohon tunggu sebentar</p>
    </div>
</div>

<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
let currentFilename = null;
let pdfUrl = null;
let dudiSelect, jurusanSelect;

$(document).ready(function() {
    // Initialize Select2
    dudiSelect = $('#dudi_select').select2({
        placeholder: '-- Pilih DUDI --',
        allowClear: true,
        width: '100%'
    });

    jurusanSelect = $('#jurusan_select').select2({
        placeholder: '-- Pilih Jurusan --',
        allowClear: true,
        width: '100%'
    });

    // Initialize Flatpickr dengan tanggal otomatis hari ini
    flatpickr("#tanggal_surat", {
        locale: "id",
        dateFormat: "Y-m-d",
        defaultDate: "today",
        altInput: true,
        altFormat: "d F Y",
        theme: "material_blue"
    });

    flatpickr("#tanggal_mulai", {
        locale: "id",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        theme: "material_blue"
    });

    flatpickr("#tanggal_selesai", {
        locale: "id",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        theme: "material_blue"
    });

    // Auto-fill alamat when DUDI selected - FIX: Gunakan URL manual
    dudiSelect.on('change', function() {
        const dudiId = $(this).find(':selected').data('id');
        
        if (dudiId) {
            // FIX: Gunakan URL manual dengan base URL + path
            fetch(`${window.location.origin}/api/dudi/${dudiId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#alamat_dudi').val(data.data.alamat);
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            $('#alamat_dudi').val('');
        }
    });

    // Form submission untuk preview
    $('#suratForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validasi form
        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        // Tampilkan loading
        $('#loadingModal').removeClass('hidden');

        // Submit form via AJAX
        $.ajax({
            url: '{{ route("surat.penjajakan.preview") }}',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                $('#loadingModal').addClass('hidden');
                
                if (response.success) {
                    currentFilename = response.filename;
                    pdfUrl = response.pdf_url;
                    
                    // Tampilkan PDF di iframe
                    $('#pdfPreview').html(`
                        <iframe src="${response.pdf_url}" 
                                style="width: 100%; height: 600px; border: none;" 
                                onload="this.style.height=(this.contentWindow.document.body.scrollHeight+20)+'px'">
                        </iframe>
                    `);
                    
                    // Tampilkan modal preview
                    $('#previewModal').removeClass('hidden');
                } else {
                    alert('Gagal membuat preview: ' + response.message);
                }
            },
            error: function(xhr) {
                $('#loadingModal').addClass('hidden');
                alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });
});

// Fungsi tutup preview
function closePreview() {
    $('#previewModal').addClass('hidden');
}

// Fungsi cetak surat
function printSurat() {
    if (pdfUrl) {
        const printWindow = window.open(pdfUrl, '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
}

// Fungsi download surat
function downloadSurat(type) {
    if (!currentFilename) return;
    
    $('#loadingModal').removeClass('hidden');
    
    $.ajax({
        url: '{{ route("surat.penjajakan.download") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            filename: currentFilename,
            type: type
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response, status, xhr) {
            $('#loadingModal').addClass('hidden');
            
            const blob = new Blob([response]);
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            
            const disposition = xhr.getResponseHeader('Content-Disposition');
            const filename = disposition ? 
                disposition.match(/filename="(.+)"/)[1] : 
                `surat_penjajakan.${type}`;
            
            link.download = filename;
            link.click();
        },
        error: function() {
            $('#loadingModal').addClass('hidden');
            alert('Gagal mengunduh file');
        }
    });
}
</script>
@endsection