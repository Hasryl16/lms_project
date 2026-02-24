<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #e0e7ff 100%);
            min-height: 100vh;
        }
        .login-card {
            max-width: 450px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .role-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .student-icon { background: #dbeafe; color: #2563eb; }
        .lecturer-icon { background: #f3e8ff; color: #9333ea; }
        .admin-icon { background: #dcfce7; color: #16a34a; }
        .nav-pills .nav-link {
            border-radius: 0.5rem;
        }
        .nav-pills .nav-link.active {
            background: #2563eb;
        }
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 p-4">
        <div class="w-100">
            <div class="text-center mb-4">
                <div class="role-icon mx-auto mb-3" style="background: #2563eb; color: white;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h1 class="h3 fw-bold">Learning Management System</h1>
                <p class="text-muted">Sign in to your account</p>
            </div>

            <div class="card login-card mx-auto">
                <div class="card-body p-4" id="loginCardBody">
                    <h5 class="card-title text-center mb-3">Welcome Back</h5>
                    <p class="text-center text-muted small mb-4">Choose your role and sign in to continue</p>
                    
                    <ul class="nav nav-pills mb-4" id="roleTabs" role="tablist">
                        <li class="nav-item w-33">
                            <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#student" type="button">
                                <i class="bi bi-person-fill me-1"></i> Student
                            </button>
                        </li>
                        <li class="nav-item w-33">
                            <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#lecturer" type="button">
                                <i class="bi bi-book-fill me-1"></i> Lecturer
                            </button>
                        </li>
                        <li class="nav-item w-33">
                            <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#admin" type="button">
                                <i class="bi bi-shield-fill me-1"></i> Admin
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Student Login -->
                        <div class="tab-pane fade show active" id="student">
                            <form onsubmit="handleLogin(event, 'student')">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="studentEmail" placeholder="student@university.edu" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="studentPassword" placeholder="Enter password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="studentBtn">Sign In as Student</button>
                            </form>
                        </div>

                        <!-- Lecturer Login -->
                        <div class="tab-pane fade" id="lecturer">
                            <form onsubmit="handleLogin(event, 'lecturer')">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="lecturerEmail" placeholder="lecturer@university.edu" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="lecturerPassword" placeholder="Enter password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background: #9333ea; border-color: #9333ea;" id="lecturerBtn">Sign In as Lecturer</button>
                            </form>
                        </div>

                        <!-- Admin Login -->
                        <div class="tab-pane fade" id="admin">
                            <form onsubmit="handleLogin(event, 'admin')">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="adminEmail" placeholder="admin@university.edu" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="adminPassword" placeholder="Enter password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background: #16a34a; border-color: #16a34a;" id="adminBtn">Sign In as Admin</button>
                            </form>
                        </div>
                    </div>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-3">Quick Access</p>
                    <div class="row g-2">
                        <div class="col-4">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillDemo('student')">
                                <i class="bi bi-person"></i> Demo Student
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillDemo('lecturer')">
                                <i class="bi bi-book"></i> Demo Lecturer
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillDemo('admin')">
                                <i class="bi bi-shield"></i> Demo Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center mt-4 text-muted small">
                Don't have an account? <a href="#" class="text-decoration-none">Contact administrator</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Base URL from the server
        const BASE_URL = '<?= base_url() ?>';
        
        function fillDemo(role) {
            const emails = {
                student: 'student@edu.com',
                lecturer: 'lecturer@edu.com',
                admin: 'admin@edu.com'
            };
            const passwords = {
                student: 'student123',
                lecturer: 'lecturer123',
                admin: 'admin123'
            };

            // Switch to correct tab
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            tabs.forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            
            const tabMap = { student: 0, lecturer: 1, admin: 2 };
            tabs[tabMap[role]].classList.add('active');
            
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => pane.classList.remove('show', 'active'));
            document.getElementById(role).classList.add('show', 'active');

            // Fill credentials
            document.getElementById(role + 'Email').value = emails[role];
            document.getElementById(role + 'Password').value = passwords[role];
        }

        async function handleLogin(event, role) {
            event.preventDefault();
            
            const email = document.getElementById(role + 'Email').value;
            const password = document.getElementById(role + 'Password').value;
            const btn = document.getElementById(role + 'Btn');

            if (!email || !password) {
                alert('Please enter email and password');
                return;
            }

            // Show loading state
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Signing in...';
            document.getElementById('loginCardBody').classList.add('loading');

            try {
                const response = await fetch(BASE_URL + '/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        role: role
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Store token and user info
                    localStorage.setItem('authToken', data.token);
                    localStorage.setItem('currentUserRole', data.user.role);
                    localStorage.setItem('currentUser', JSON.stringify(data.user));
                    
                    // Redirect based on role
                    window.location.href = data.redirectUrl;
                } else {
                    alert(data.message || 'Login failed. Please check your credentials.');
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('An error occurred during login. Please try again.');
            } finally {
                // Reset button state
                btn.disabled = false;
                btn.innerHTML = 'Sign In as ' + role.charAt(0).toUpperCase() + role.slice(1);
                document.getElementById('loginCardBody').classList.remove('loading');
            }
        }
    </script>
</body>
</html>
