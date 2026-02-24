<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Manage Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; position: fixed; left: 0; top: 0; z-index: 100; }
        .main-content { margin-left: 260px; min-height: 100vh; background: #f8f9fa; }
        .nav-link.active { background-color: #0d6efd; color: white !important; }
        .nav-link { color: #495057; }
    </style>
</head>
<body>
    <div class="d-flex">
        <aside class="bg-white border-end">
            <div class="p-4 border-bottom">
                <h1 class="h4 fw-bold text-dark">LMS Admin</h1>
                <p class="small text-muted mb-0">Management Portal</p>
            </div>
            <nav class="p-3">
                <div class="nav flex-column">
                    <a href="<?= base_url('/admin') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('/admin/courses') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-book me-2"></i>Courses
                    </a>
                    <a href="<?= base_url('/admin/students') ?>" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-people me-2"></i>Students
                    </a>
                    <a href="<?= base_url('/admin/lecturers') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-person-badge me-2"></i>Lecturers
                    </a>
                    <a href="<?= base_url('/admin/enrollments') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-person-plus me-2"></i>Enrollments
                    </a>
                </div>
            </nav>
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <button onclick="logout()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </button>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 fw-bold text-dark">Students</h1>
                        <p class="text-muted">View all registered students</p>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Total Students</p>
                                <h3 class="fw-bold mb-0" id="studentsTotal">-</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="position-relative" style="max-width: 400px;">
                        <i class="bi bi-search position-absolute start-0 top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Search students..." id="studentSearch" onkeyup="filterStudents()">
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody">
                                <tr><td colspan="4" class="text-center text-muted py-4">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        let token = urlParams.get('token');
        
        if (!token) {
            token = localStorage.getItem('authToken');
        }
        
        if (!token) {
            window.location.href = '<?= base_url('/login') ?>';
        }
        
        localStorage.setItem('authToken', token);
        
        const API_BASE = '<?= rtrim(base_url(), '/') ?>';
        let allStudents = [];
        
        function getHeaders() {
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            };
        }
        
        function logout() {
            localStorage.removeItem('authToken');
            window.location.href = '<?= base_url('/login') ?>';
        }
        
        async function loadStudents() {
            try {
                const response = await fetch(API_BASE + '/admin/api/students', {
                    headers: getHeaders()
                });
                const result = await response.json();
                
                if (result.success) {
                    allStudents = result.data;
                    renderStudentsTable(allStudents);
                    document.getElementById('studentsTotal').textContent = result.data.length;
                } else {
                    document.getElementById('studentsTableBody').innerHTML = 
                        '<tr><td colspan="4" class="text-center text-danger py-4">Error loading students</td></tr>';
                }
            } catch (e) {
                console.error('Error:', e);
                document.getElementById('studentsTableBody').innerHTML = 
                    '<tr><td colspan="4" class="text-center text-danger py-4">Error connecting to server</td></tr>';
            }
        }
        
        function renderStudentsTable(students) {
            if (students.length === 0) {
                document.getElementById('studentsTableBody').innerHTML = 
                    '<tr><td colspan="4" class="text-center text-muted py-4">No students found</td></tr>';
                return;
            }
            
            const html = students.map(student => `
                <tr>
                    <td>${student.id}</td>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td><small class="text-muted">${student.created_at || '-'}</small></td>
                </tr>
            `).join('');
            document.getElementById('studentsTableBody').innerHTML = html;
        }
        
        function filterStudents() {
            const query = document.getElementById('studentSearch').value.toLowerCase();
            const filtered = allStudents.filter(s => 
                s.name.toLowerCase().includes(query) || 
                s.email.toLowerCase().includes(query)
            );
            renderStudentsTable(filtered);
        }
        
        loadStudents();
    </script>
</body>
</html>
