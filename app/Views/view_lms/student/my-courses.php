<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - My Courses</title>
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
                    <h1 class="h3 fw-bold text-dark">My Courses</h1>
                    <p class="text-muted">Courses you're currently enrolled in</p>
                </div>

                <div class="mb-3">
                    <span class="badge bg-primary fs-6">Total: <?= count($courses) ?? 0 ?> courses</span>
                </div>

                <div class="row g-4" id="myCoursesGrid">
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-primary"><?= $course['course_code'] ?? 'N/A' ?></span>
                                            <span class="badge bg-outline-secondary border"><?= $course['module_count'] ?? 0 ?> modules</span>
                                        </div>
                                        <h5 class="card-title fw-bold"><?= $course['title'] ?></h5>
                                        <p class="card-text text-muted small"><?= $course['description'] ?></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                                            <i class="bi bi-person"></i>
                                            <span><?= $course['lecturer_name'] ?? 'No lecturer assigned' ?></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                                            <i class="bi bi-calendar"></i>
                                            <span>Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'] ?? date('Y-m-d'))) ?></span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0 d-flex gap-2">
                                        <a href="<?= base_url('student/course/' . $course['id']) ?>" class="btn btn-primary flex-grow-1">
                                            Continue Learning
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="unenrollCourse(<?= $course['id'] ?>)">
                                            Unenroll
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-book fs-1 text-muted"></i>
                            <p class="text-muted mt-3">You haven't enrolled in any courses yet</p>
                            <a href="<?= base_url('student/browse') ?>" class="btn btn-primary">Browse Courses</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Unenroll Confirmation Modal -->
    <div class="modal fade" id="unenrollModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Unenrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to unenroll from this course?</p>
                    <input type="hidden" id="unenrollCourseId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmUnenroll()">Unenroll</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let unenrollModal;
        
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
            unenrollModal = new bootstrap.Modal(document.getElementById('unenrollModal'));
        });

        function unenrollCourse(courseId) {
            document.getElementById('unenrollCourseId').value = courseId;
            unenrollModal.show();
        }

        function confirmUnenroll() {
            const courseId = document.getElementById('unenrollCourseId').value;
            const formData = new FormData();
            formData.append(getCsrfTokenName(), getCsrfToken());
            
            const jwtToken = getJwtToken();
            
            fetch(`<?= base_url('student/unenroll/') ?>${courseId}`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + jwtToken
                },
                body: formData,
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    unenrollModal.hide();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert(data.message || 'Failed to unenroll');
                }
            })
            .catch(error => {
                alert('An error occurred');
            });
        }
    </script>
</body>
</html>
