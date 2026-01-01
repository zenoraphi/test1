@extends('layouts.app')

@section('title', 'Buat Surat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">
                <i class="fas fa-envelope-open-text text-blue-600 mr-3"></i>
                Buat Surat PKL
            </h1>
            <p class="text-gray-600 text-lg">Pilih jenis surat yang ingin Anda buat</p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Surat Penjajakan -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-slide-up" style="animation-delay: 0.1s">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-file-contract text-yellow-500 text-3xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-xl">Surat Penjajakan</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6 h-20">
                        Buat surat permohonan PKL ke perusahaan atau instansi
                    </p>
                    <a href="{{ route('surat.penjajakan') }}" 
                       class="block w-full bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-edit mr-2"></i>Buat Surat
                    </a>
                </div>
            </div>

            <!-- Surat Penempatan -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-slide-up" style="animation-delay: 0.2s">
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 p-6 text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-map-marker-alt text-blue-500 text-3xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-xl">Surat Penempatan</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6 h-20">
                        Buat surat penempatan siswa PKL di perusahaan
                    </p>
                    <button 
                       onclick="showComingSoon()"
                       class="block w-full bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-edit mr-2"></i>Buat Surat
                    </button>
                </div>
            </div>

            <!-- Surat Penarikan -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-slide-up" style="animation-delay: 0.3s">
                <div class="bg-gradient-to-r from-red-400 to-red-500 p-6 text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-user-times text-red-500 text-3xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-xl">Surat Penarikan</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6 h-20">
                        Buat surat penarikan siswa dari tempat PKL
                    </p>
                    <button 
                       onclick="showComingSoon()"
                       class="block w-full bg-gradient-to-r from-red-400 to-red-500 hover:from-red-500 hover:to-red-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-edit mr-2"></i>Buat Surat
                    </button>
                </div>
            </div>

            <!-- Surat Tugas -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-slide-up" style="animation-delay: 0.4s">
                <div class="bg-gradient-to-r from-green-400 to-green-500 p-6 text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-clipboard-check text-green-500 text-3xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-xl">Surat Tugas</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6 h-20">
                        Buat surat tugas untuk pembimbing PKL
                    </p>
                    <button 
                       onclick="showComingSoon()"
                       class="block w-full bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-edit mr-2"></i>Buat Surat
                    </button>
                </div>
            </div>

        </div>

        <!-- Info Section -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8 animate-fade-in">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Informasi Penting</h4>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Pastikan semua data yang diinputkan sudah benar sebelum membuat surat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Anda dapat melihat preview surat sebelum mencetak atau mengunduh</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                            <span>Surat dapat diunduh dalam format PDF atau DOCX</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Coming Soon Modal -->
<div id="comingSoonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-fade-in">
    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 animate-slide-up">
        <div class="text-center">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clock text-blue-600 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Segera Hadir!</h3>
            <p class="text-gray-600 mb-6">Fitur ini sedang dalam pengembangan dan akan segera tersedia.</p>
            <button onclick="hideComingSoon()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-300">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function showComingSoon() {
    document.getElementById('comingSoonModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideComingSoon() {
    document.getElementById('comingSoonModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
@endsection