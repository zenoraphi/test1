<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Administrasi PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        'primary-light': '#4895ef',
                        secondary: '#3a0ca3',
                        success: '#4cc9f0',
                        danger: '#f72585',
                        dark: '#212529',
                        light: '#f8f9fa',
                        gray: '#6c757d',
                        'gray-light': '#e9ecef',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px',a
                    },
                    boxShadow: {
                        'card': '0 10px 20px rgba(0, 0, 0, 0.08)',
                        'card-hover': '0 15px 30px rgba(0, 0, 0, 0.12)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease',
                        'slide-in': 'slideIn 0.3s ease',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(-10px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .gradient-primary {
            background: linear-gradient(to right, #4361ee, #3a0ca3);
        }
        .gradient-primary-reverse {
            background: linear-gradient(to right, #3a0ca3, #4361ee);
        }
        .gradient-accent {
            background: linear-gradient(to right, #4361ee, #4cc9f0);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        .floating-label {
            transition: all 0.2s ease;
        }
        .floating-input:focus + .floating-label,
        .floating-input:not(:placeholder-shown) + .floating-label {
            transform: translateY(-28px) translateX(-10px) scale(0.85);
            color: #4361ee;
            font-weight: 600;
            background-color: white;
            padding: 0 8px;
        }

        /* Role tabs styling */
        .role-tab {
            transition: all 0.2s ease;
        }
        .role-tab:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        .role-tab.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: #4361ee;
            border-color: #4361ee;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Background overlay */
        .bg-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(67, 97, 238, 0.85);
            z-index: 1;
        }

        /* Background dengan gambar sekolah/teknologi */
        body {
            background-image: url('https://shorturl.at/emgCE');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }



        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 md:p-6 font-sans relative">
    <!-- Background blur layer -->
    <div class="absolute inset-0 backdrop-blur-sm bg-black/20 z-0"></div>
    <!-- Container utama -->
    <div class="w-full max-w-md animate-fade-in relative z-10">
        <div class="bg-white rounded-2xl shadow-[0_25px_60px_rgba(0,0,0,0.18)] ring-1 ring-black/5 overflow-hidden">
            <div class="gradient-primary p-6 md:p-8 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="inline-block bg-white rounded-full p-4 shadow-lg">
                        <img src="{{ asset('asset/logo-smk.webp') }}" alt="Logo SMK" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                    </div>
                    <h1 class="text-white text-3xl font-bold mt-4">LOGIN</h1>
                    <p class="text-white/80 text-sm mt-2">Untuk Mengakses Sistem</p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                @if (session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700 flex items-start animate-slide-in">
                    <i class="fas fa-exclamation-circle mt-0.5 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="mb-8">
                        <label class="block text-gray-700 font-medium mb-3">Pilih Jenis Akun</label>

                        <div class="flex space-x-2 mb-2">
                            <button type="button" class="role-tab flex-1 py-2.5 px-4 rounded-lg border border-gray-200 text-center font-medium text-gray-700 active" data-role="super_admin">
                                <i class="fas fa-user-shield mr-2"></i>
                                Super Admin
                            </button>

                            <button type="button" class="role-tab flex-1 py-2.5 px-4 rounded-lg border border-gray-200 text-center font-medium text-gray-700" data-role="admin_jurusan">
                                <i class="fas fa-user-tie mr-2"></i>
                                Admin Jurusan
                            </button>
                        </div>

                        <div class="hidden">
                            <input type="radio" name="role" id="role_super_admin" value="super_admin" checked>
                            <input type="radio" name="role" id="role_admin_jurusan" value="admin_jurusan">
                            <input type="radio" name="role" id="role_siswa" value="siswa">
                        </div>

                        @error('role')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="relative">
                            <input
                                type="text"
                                id="login"
                                name="login"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:outline-none input-focus floating-input"
                                value="{{ old('login') }}"
                                placeholder=" "
                                required
                            >
                            <label for="login" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none" id="loginLabel">
                                Username
                            </label>
                        </div>
                        @error('login')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-primary focus:outline-none input-focus floating-input pr-12"
                                placeholder=" "
                                required
                            >
                            <label for="password" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Password
                            </label>
                            <button type="button" id="togglePassword" class="absolute right-4 top-3 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full gradient-primary text-white font-medium py-3.5 px-4 rounded-lg hover:gradient-primary-reverse transition-all duration-300 shadow-md hover:shadow-lg active:shadow-md relative overflow-hidden">
                            <span class="relative z-10" id="btnText">Login</span>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 hidden" id="btnLoader">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600 text-sm">
                        <i class="fas fa-shield-alt text-primary mr-1"></i>
                        Sistem Administrasi PKL
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleTabs = document.querySelectorAll('.role-tab');
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const loginLabel = document.getElementById('loginLabel');
            const loginInput = document.getElementById('login');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            function setActiveRole(roleValue) {
                roleTabs.forEach(tab => {
                    if (tab.getAttribute('data-role') === roleValue) {
                        tab.classList.add('active');
                        tab.classList.remove('text-gray-700');
                        tab.classList.add('text-primary');
                        tab.classList.remove('border-gray-200');
                        tab.classList.add('border-primary');
                    } else {
                        tab.classList.remove('active');
                        tab.classList.remove('text-primary');
                        tab.classList.add('text-gray-700');
                        tab.classList.remove('border-primary');
                        tab.classList.add('border-gray-200');
                    }
                });

                roleInputs.forEach(input => {
                    input.checked = (input.value === roleValue);
                });

                if (roleValue === 'siswa') {
                    loginLabel.textContent = 'NIS';
                } else {
                    loginLabel.textContent = 'Username';
                }

                if (loginInput.value) {
                    loginLabel.classList.add('floating-label-active');
                }
            }

            roleTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const roleValue = this.getAttribute('data-role');
                    setActiveRole(roleValue);
                });
            });

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                    this.classList.add('text-primary');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                    this.classList.remove('text-primary');
                }
            });

            loginForm.addEventListener('submit', function(e) {
                if (!loginInput.value.trim() || !passwordInput.value.trim()) {
                    e.preventDefault();
                    if (!loginInput.value.trim()) {
                        loginInput.classList.add('border-red-500');
                        loginInput.focus();
                        setTimeout(() => {
                            loginInput.classList.remove('border-red-500');
                        }, 2000);
                    } else if (!passwordInput.value.trim()) {
                        passwordInput.classList.add('border-red-500');
                        passwordInput.focus();
                        setTimeout(() => {
                            passwordInput.classList.remove('border-red-500');
                        }, 2000);
                    }
                    return;
                }
                btnText.textContent = 'Memproses...';
                btnLoader.classList.remove('hidden');
                const submitBtn = loginForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                setTimeout(() => {
                    btnText.textContent = 'Login';
                    btnLoader.classList.add('hidden');
                    submitBtn.disabled = false;
                }, 3000);
            });
            loginInput.focus();
            setActiveRole('super_admin');
        });
    </script>
</body>
</html>
