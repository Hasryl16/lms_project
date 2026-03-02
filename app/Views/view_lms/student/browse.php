<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Browse Courses</title>
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
                <h1 class="h4 fw-bold text-primary">Student Portal</h1>
                <p class="small text-muted mb-0">Learning Hub</p>
            </div>
            <nav class="p-3">
                <div class="nav flex-column">
                    <a href="<?= base_url('student/dashboard') ?>" class="nav-link rounded px-3 py-2 <?= uri_string() === 'student/dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('student/browse') ?>" class="nav-link rounded px-3 py-2 <?= uri_string() === 'student/browse' ? 'active' : '' ?>">
                        <i class="bi bi-search me-2"></i>Browse Courses
                    </a>
                    <a href="<?= base_url('student/my-courses') ?>" class="nav-link rounded px-3 py-2 <?= uri_string() === 'student/my-courses' ? 'active' : '' ?>">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="<?= base_url('student/assignments') ?>" class="nav-link rounded px-3 py-2 <?= uri_string() === 'student/assignments' ? 'active' : '' ?>">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="<?= base_url('student/grades') ?>" class="nav-link rounded px-3 py-2 <?= uri_string() === 'student/grades' ? 'active' : '' ?>">
                        <i class="bi bi-award me-2"></i>Grades
                    </a>
                </div>
            </nav>
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-dark">Browse Courses</h1>
                    <p class="text-muted">Discover and enroll in new courses</p>
                </div>

                <!-- Enroll by Course Code -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Enroll by Course Code</h5>
                        <form id="enrollByCodeForm" class="d-flex gap-2">
                            <input type="text" class="form-control" id="courseCodeInput" placeholder="Enter course code (e.g., PW001)">
                            <button type="submit" class="btn btn-primary">Enroll</button>
                        </form>
                        <div id="enrollMessage" class="mt-2"></div>
                    </div>
                </div>

                <!-- Course List -->
                <div class="row g-4" id="coursesGrid">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <span class="badge bg-primary"><?= $course['course_code'] ?? 'N/A' ?></span>
                                        <h5 class="card-title fw-bold mt-2"><?= $course['title'] ?></h5>
                                        <p class="card-text text-muted small"><?= $course['description'] ?></p>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="small text-muted">
                                            <p class="mb-1"><i class="bi bi-person me-2"></i><?= $course['lecturer_name'] ?? 'No lecturer assigned' ?></p>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <button class="btn btn-primary w-100" onclick="enrollCourse(<?= $course['id'] ?>)">
                                            Enroll Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-search fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No courses available to enroll</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Enrollment Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to enroll in this course?</p>
                    <input type="hidden" id="enrollCourseId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmEnroll()">Confirm Enrollment</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let enrollModal;
        
        // Get CSRF token for AJAX requests
        function getCsrfToken() {
            return '<?= csrf_hash() ?>';
        }
        
        function getCsrfTokenName() {
            return '<?= csrf_token() ?>';
        }
        
        // Get JWT token from localStorage (set during login)
        function getJwtToken() {
            return localStorage.getItem('authToken') || '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            enrollModal = new bootstrap.Modal(document.getElementById('enrollModal'));
            
            // Enroll by code form
            document.getElementById('enrollByCodeForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const code = document.getElementById('courseCodeInput').value.trim();
                if (code) {
                    enrollByCode(code);
                }
            });
        });

        function enrollCourse(courseId) {
            document.getElementById('enrollCourseId').value = courseId;
            enrollModal.show();
        }

        function confirmEnroll() {
            const courseId = document.getElementById('enrollCourseId').value;
            const formData = new FormData();
            formData.append(getCsrfTokenName(), getCsrfToken());
            formData.append('course_id', courseId);
            
            const jwtToken = getJwtToken();
            
            fetch('<?= base_url('student/enroll') ?>', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + jwtToken
                },
                body: formData,
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success);
                if (data.success) {
                    enrollModal.hide();
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                showMessage('An error occurred', false);
            });
        }

        function enrollByCode(code) {
            const formData = new FormData();
            formData.append(getCsrfTokenName(), getCsrfToken());
            formData.append('course_code', code);
            
            const jwtToken = getJwtToken();
            
            fetch('<?= base_url('student/enroll') ?>', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + jwtToken
                },
                body: formData,
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success);
                if (data.success) {
                    document.getElementById('courseCodeInput').value = '';
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                showMessage('An error occurred', false);
            });
        }

        function showMessage(message, success) {
            const msgDiv = document.getElementById('enrollMessage');
            msgDiv.innerHTML = `<div class="alert ${success ? 'alert-success' : 'alert-danger'}">${message}</div>`;
            setTimeout(() => msgDiv.innerHTML = '', 5000);
        }
    </script>
</body>
</html>
