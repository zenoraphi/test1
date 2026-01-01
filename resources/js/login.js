document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const loginForm = document.getElementById('loginForm');
    const roleCards = document.querySelectorAll('.role-card');
    const indicatorDots = document.querySelectorAll('.indicator-dot');
    const selectedRoleSpan = document.getElementById('selected-role');
    const roleInput = document.getElementById('role');
    const changeRoleBtn = document.getElementById('changeRole');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const submitBtn = document.getElementById('submitBtn');
    const usernameInput = document.getElementById('username');
    const nipField = document.querySelector('.admin-field');
    const usernameLabel = document.getElementById('username-label');

    // Role Configuration
    const roleConfig = {
        'siswa': {
            title: 'Siswa PKL',
            label: 'NIS / Username',
            placeholder: 'Masukkan NIS atau username',
            showNIP: false
        },
        'admin': {
            title: 'Admin Jurusan',
            label: 'Username',
            placeholder: 'Masukkan username admin',
            showNIP: true
        },
        'super-admin': {
            title: 'Super Admin',
            label: 'Username',
            placeholder: 'Masukkan username super admin',
            showNIP: true
        }
    };

    let selectedRole = 'siswa';

    // Role Selection Animation
    function selectRole(role) {
        selectedRole = role;

        // Update role cards
        roleCards.forEach(card => {
            card.classList.remove('active');
            if (card.dataset.role === role) {
                card.classList.add('active');
                // Add bounce animation
                card.style.animation = 'bounce 0.6s ease';
                setTimeout(() => {
                    card.style.animation = 'pulse 2s infinite';
                }, 600);
            }
        });

        // Update indicator dots
        indicatorDots.forEach(dot => {
            dot.classList.remove('active');
            if (dot.dataset.role === role) {
                dot.classList.add('active');
            }
        });

        // Update form
        updateFormForRole(role);

        // Add form slide-in animation
        const formContainer = document.querySelector('.login-form-container');
        formContainer.style.animation = 'slideIn 0.6s ease';
    }

    // Update form based on selected role
    function updateFormForRole(role) {
        const config = roleConfig[role];

        // Update displayed role
        selectedRoleSpan.textContent = config.title;
        selectedRoleSpan.style.background = `linear-gradient(45deg, ${getRoleColor(role)}, ${getRoleSecondaryColor(role)})`;
        selectedRoleSpan.style.webkitBackgroundClip = 'text';
        selectedRoleSpan.style.webkitTextFillColor = 'transparent';

        // Update username field
        usernameLabel.textContent = config.label;
        usernameInput.placeholder = config.placeholder;
        usernameInput.value = '';

        // Show/hide NIP field
        if (config.showNIP) {
            nipField.style.display = 'block';
            nipField.style.animation = 'fadeInUp 0.5s ease';
        } else {
            nipField.style.display = 'none';
        }

        // Update hidden role input
        roleInput.value = role;
    }

    // Get role colors
    function getRoleColor(role) {
        const colors = {
            'siswa': '#3b82f6',
            'admin': '#8b5cf6',
            'super-admin': '#f59e0b'
        };
        return colors[role] || '#2563eb';
    }

    function getRoleSecondaryColor(role) {
        const colors = {
            'siswa': '#60a5fa',
            'admin': '#a78bfa',
            'super-admin': '#fbbf24'
        };
        return colors[role] || '#8b5cf6';
    }

    // Toggle password visibility
    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon with animation
            eyeIcon.style.transform = 'scale(0)';
            setTimeout(() => {
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
                eyeIcon.style.transform = 'scale(1)';
            }, 150);
        });
    }

    // Role card click handlers
    roleCards.forEach(card => {
        card.addEventListener('click', function() {
            const role = this.dataset.role;
            selectRole(role);
        });
    });

    // Indicator dot click handlers
    indicatorDots.forEach(dot => {
        dot.addEventListener('click', function() {
            const role = this.dataset.role;
            selectRole(role);
        });
    });

    // Change role button
    if (changeRoleBtn) {
        changeRoleBtn.addEventListener('click', function() {
            const roleSelection = document.querySelector('.role-selection');
            const formContainer = document.querySelector('.login-form-container');

            // Animate transition
            formContainer.style.animation = 'slideIn 0.6s ease reverse';
            setTimeout(() => {
                formContainer.style.display = 'none';
                roleSelection.style.display = 'block';
                roleSelection.style.animation = 'fadeInUp 0.6s ease';
            }, 300);
        });
    }

    // Form validation functions
    function validateUsername(username, role) {
        if (!username.trim()) {
            return 'Username wajib diisi';
        }

        if (role === 'siswa') {
            const nisRegex = /^\d{8,}$/;
            if (!nisRegex.test(username)) {
                return 'NIS harus berupa angka dan minimal 8 digit';
            }
        }

        return '';
    }

    function validatePassword(password) {
        if (!password) {
            return 'Password wajib diisi';
        }
        if (password.length < 6) {
            return 'Password minimal 6 karakter';
        }
        return '';
    }

    function validateNIP(nip) {
        if (nip && nip.trim() && !/^\d{8,}$/.test(nip.trim())) {
            return 'NIP harus berupa angka dan minimal 8 digit';
        }
        return '';
    }

    function showError(inputId, message) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);

        if (errorElement && inputElement) {
            errorElement.textContent = message;
            inputElement.classList.add('error');
            inputElement.style.borderColor = '#ef4444';
            inputElement.style.animation = 'shake 0.5s ease';
        }
    }

    function clearError(inputId) {
        const errorElement = document.getElementById(inputId + '-error');
        const inputElement = document.getElementById(inputId);

        if (errorElement && inputElement) {
            errorElement.textContent = '';
            inputElement.classList.remove('error');
            inputElement.style.borderColor = '';
            inputElement.style.animation = '';
        }
    }

    function showAlert(message, type = 'error') {
        const alertContainer = document.getElementById('alert-container');
        if (!alertContainer) return;

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;

        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertDiv);

        setTimeout(() => {
            if (alertDiv.parentNode === alertContainer) {
                alertDiv.style.animation = 'fadeOut 0.5s ease';
                setTimeout(() => alertDiv.remove(), 500);
            }
        }, 5000);
    }

    // Add shake animation for errors
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Real-time validation
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            clearError('username');
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            clearError('password');
        });
    }

    // Form submission
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Clear previous errors
            clearError('username');
            clearError('password');
            clearError('nip');

            // Get form data
            const formData = new FormData(this);
            const username = formData.get('username') ? formData.get('username').trim() : '';
            const password = formData.get('password') || '';
            const nip = formData.get('nip') ? formData.get('nip').trim() : '';
            const remember = formData.get('remember') ? true : false;

            // Validation
            let hasError = false;

            const usernameError = validateUsername(username, selectedRole);
            if (usernameError) {
                showError('username', usernameError);
                hasError = true;
            }

            const passwordError = validatePassword(password);
            if (passwordError) {
                showError('password', passwordError);
                hasError = true;
            }

            if (selectedRole !== 'siswa') {
                const nipError = validateNIP(nip);
                if (nipError) {
                    showError('nip', nipError);
                    hasError = true;
                }
            }

            if (hasError) return;

            // Disable submit button and show loading
            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').style.display = 'none';
            submitBtn.querySelector('.btn-loader').style.display = 'inline-block';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password,
                        nip: nip,
                        role: selectedRole,
                        remember: remember
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert(data.message || 'Login berhasil!', 'success');

                    // Add success animation
                    submitBtn.style.background = 'linear-gradient(45deg, #10b981, #34d399)';

                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            showError(key, data.errors[key][0]);
                        });
                    } else {
                        showAlert(data.message || 'Login gagal. Periksa kembali data Anda.');
                    }
                }
            } catch (error) {
                console.error('Login Error:', error);
                showAlert('Terjadi kesalahan koneksi. Periksa jaringan Anda.');
            } finally {
                // Re-enable submit button
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.querySelector('.btn-text').style.display = 'inline-block';
                    submitBtn.querySelector('.btn-loader').style.display = 'none';
                    submitBtn.style.background = '';
                }, 1000);
            }
        });
    }

    // Auto-select role from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const roleParam = urlParams.get('role');
    if (roleParam && ['siswa', 'admin', 'super-admin'].includes(roleParam)) {
        selectRole(roleParam);
    }

    // Initialize
    selectRole('siswa');
});
