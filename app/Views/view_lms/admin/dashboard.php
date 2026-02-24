<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Admin Dashboard</title>
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
                    <a href="<?= base_url('/admin') ?>" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('/admin/courses') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-book me-2"></i>Courses
                    </a>
                    <a href="<?= base_url('/admin/students') ?>" class="nav-link rounded px-3 py-2">
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
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-dark">Dashboard</h1>
                        <p class="text-muted">Welcome to your LMS admin portal</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted" id="userInfo">Loading...</span>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Total Courses</p>
                                        <h2 class="fw-bold mb-0" id="totalCourses">-</h2>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded p-3">
                                        <i class="bi bi-book fs-4 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Enrolled Students</p>
                                        <h2 class="fw-bold mb-0" id="totalStudents">-</h2>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <i class="bi bi-people fs-4 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Active Lecturers</p>
                                        <h2 class="fw-bold mb-0" id="activeLecturers">-</h2>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <i class="bi bi-person-badge fs-4 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Enrollments</p>
                                        <h2 class="fw-bold mb-0" id="totalEnrollments">-</h2>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <i class="bi bi-person-plus fs-4 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Recent Courses</h5>
                            </div>
                            <div class="card-body" id="recentCourses">
                                <p class="text-muted text-center py-3">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Recent Enrollments</h5>
                            </div>
                            <div class="card-body" id="recentEnrollments">
                                <p class="text-muted text-center py-3">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get token from URL or localStorage
        const urlParams = new URLSearchParams(window.location.search);
        let token = urlParams.get('token');
        
        // If no token in URL, check localStorage first
        if (!token) {
            token = localStorage.getItem('authToken');
        }
        
        // Only redirect to login if no token found anywhere
        if (!token) {
            window.location.href = '<?= base_url('/login') ?>';
        }
        
        localStorage.setItem('authToken', token);
        
        const API_BASE = '<?= rtrim(base_url(), '/') ?>';
        
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
        
        async function loadUserInfo() {
            try {
                const response = await fetch(API_BASE + '/auth/me', {
                    headers: getHeaders()
                });
                const result = await response.json();
                if (result.success) {
                    document.getElementById('userInfo').textContent = result.user.name + ' (' + result.user.role + ')';
                } else {
                    logout();
                }
            } catch (e) {
                console.error(e);
            }
        }
        
        async function loadDashboardData() {
            try {
                const coursesRes = await fetch(API_BASE + '/admin/api/courses', { headers: getHeaders() });
                const coursesData = await coursesRes.json();
                
                const lecturersRes = await fetch(API_BASE + '/admin/api/lecturers', { headers: getHeaders() });
                const lecturersData = await lecturersRes.json();
                
                const studentsRes = await fetch(API_BASE + '/admin/api/students', { headers: getHeaders() });
                const studentsData = await studentsRes.json();
                
                const enrollmentsRes = await fetch(API_BASE + '/admin/api/enrollments', { headers: getHeaders() });
                const enrollmentsData = await enrollmentsRes.json();
                
                if (coursesData.success) {
                    document.getElementById('totalCourses').textContent = coursesData.data.length;
                    document.getElementById('activeLecturers').textContent = lecturersData.success ? lecturersData.data.length : 0;
                    
                    const coursesHtml = coursesData.data.slice(0, 5).map(course => `
                        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom">
                            <div>
                                <p class="fw-medium mb-0">${course.title}</p>
                                <small class="text-muted">${course.lecturer_name || 'No lecturer assigned'}</small>
                            </div>
                        </div>
                    `).join('');
                    document.getElementById('recentCourses').innerHTML = coursesHtml || '<p class="text-muted text-center py-3">No courses yet</p>';
                }
                
                if (studentsData.success) {
                    document.getElementById('totalStudents').textContent = studentsData.data.length;
                }
                
                if (enrollmentsData.success) {
                    document.getElementById('totalEnrollments').textContent = enrollmentsData.data.length;
                    
                    const enrollmentsHtml = enrollmentsData.data.slice(0, 5).map(enrollment => `
                        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom">
                            <div>
                                <p class="fw-medium mb-0">${enrollment.student_name}</p>
                                <small class="text-muted">${enrollment.course_title}</small>
                            </div>
                        </div>
                    `).join('');
                    document.getElementById('recentEnrollments').innerHTML = enrollmentsHtml || '<p class="text-muted text-center py-3">No enrollments yet</p>';
                }
                
            } catch (e) {
                console.error('Error loading dashboard:', e);
                document.getElementById('recentCourses').innerHTML = '<p class="text-danger text-center py-3">Error loading data</p>';
            }
        }
        
        loadUserInfo();
        loadDashboardData();
    </script>
</body>
</html>
