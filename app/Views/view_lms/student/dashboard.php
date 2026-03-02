<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Student Dashboard</title>
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
                    <h1 class="h3 fw-bold text-dark">Welcome back, Student!</h1>
                    <p class="text-muted">Here's your learning overview</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Enrolled Courses</p>
                                        <h3 class="fw-bold mb-0" id="enrolledCourses"><?= $enrolledCount ?? 0 ?></h3>
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
                                        <p class="text-muted small mb-0">Pending Assignments</p>
                                        <h3 class="fw-bold mb-0" id="pendingAssignments"><?= $pendingAssignments ?? 0 ?></h3>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <i class="bi bi-file-text fs-4 text-warning"></i>
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
                                        <p class="text-muted small mb-0">Graded Assignments</p>
                                        <h3 class="fw-bold mb-0"><?= $gradedCount ?? 0 ?></h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <i class="bi bi-check-circle fs-4 text-success"></i>
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
                                        <p class="text-muted small mb-0">Student ID</p>
                                        <h3 class="fw-bold mb-0"><?= $studentId ?? 'N/A' ?></h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <i class="bi bi-person fs-4 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Recent Grades</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recentGrades)): ?>
                                    <?php foreach ($recentGrades as $grade): ?>
                                        <div class="d-flex align-items-start gap-3 pb-3 border-bottom">
                                            <div class="bg-success rounded-circle mt-1" style="width: 10px; height: 10px;"></div>
                                            <div class="flex-grow-1">
                                                <p class="fw-medium mb-0"><?= $grade['assignment_title'] ?? 'Assignment' ?></p>
                                                <small class="text-muted"><?= $grade['course_title'] ?? 'Course' ?></small>
                                                <p class="small text-success mb-0">Grade: <?= $grade['score'] ?>/<?= $grade['max_score'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No graded assignments yet</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('student/browse') ?>" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Browse Courses
                                    </a>
                                    <a href="<?= base_url('student/assignments') ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-file-text me-2"></i>View Assignments
                                    </a>
                                    <a href="<?= base_url('student/my-courses') ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-book me-2"></i>My Courses
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
