<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .course-card { border: none; border-radius: 1rem; transition: transform 0.2s, box-shadow 0.2s; }
        .course-card:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .stat-box { border-radius: 0.75rem; padding: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar d-flex flex-column">
            <div class="p-4 border-bottom">
                <h4 class="fw-bold text-purple"><i class="bi bi-mortarboard-fill text-purple me-2"></i>Lecturer Portal</h4>
                <p class="text-muted small mb-0">Teaching Hub</p>
            </div>
            
            <nav class="p-3 flex-grow-1">
                <div class="nav flex-column gap-2">
                    <a href="<?= base_url('lecturer/dashboard') ?>" class="nav-link">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('lecturer/courses') ?>" class="nav-link active">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="<?= base_url('lecturer/all-modules') ?>" class="nav-link">
                        <i class="bi bi-collection me-2"></i>Modules
                    </a>
                    <a href="<?= base_url('lecturer/all-materials') ?>" class="nav-link">
                        <i class="bi bi-file-earmark-text me-2"></i>Materials
                    </a>
                    <a href="<?= base_url('lecturer/all-assignments') ?>" class="nav-link">
                        <i class="bi bi-file-check me-2"></i>Assignments
                    </a>
                    <a href="<?= base_url('lecturer/all-submissions') ?>" class="nav-link">
                        <i class="bi bi-star me-2"></i>Grading
                    </a>
                </div>
            </nav>

            <div class="p-3 border-top">
                <a href="#" onclick="logout()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
            <div class="mb-4">
                <h2 class="fw-bold">My Courses</h2>
                <p class="text-muted">Manage your teaching courses</p>
            </div>

            <?php if (!empty($courses)): ?>
            <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-lg-6">
                    <div class="card course-card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-bold mb-1"><?= esc($course['title']) ?></h5>
                            <p class="text-muted small mb-0"><?= esc($course['description'] ?? 'No description') ?></p>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dbeafe;">
                                        <i class="bi bi-people text-primary d-block mb-1"></i>
                                        <strong><?= $course['student_count'] ?? 0 ?></strong>
                                        <p class="small mb-0 text-muted">Students</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dcfce7;">
                                        <i class="bi bi-book text-success d-block mb-1"></i>
                                        <strong><?= $course['module_count'] ?? 0 ?></strong>
                                        <p class="small mb-0 text-muted">Modules</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #f3e8ff;">
                                        <i class="bi bi-award text-purple d-block mb-1"></i>
                                        <strong><?= $course['assignment_count'] ?? 0 ?></strong>
                                        <p class="small mb-0 text-muted">Assignments</p>
                                    </div>
                                </div>
                            </div>

                            <?php if (($course['pending_grading'] ?? 0) > 0): ?>
                            <div class="p-3 rounded border" style="background: #fef3c7;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small fw-medium mb-0"><?= $course['pending_grading'] ?> submissions awaiting grading</p>
                                    <span class="badge bg-warning">Action needed</span>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="p-3 rounded border" style="background: #dcfce7;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small fw-medium mb-0 text-success">All caught up</p>
                                    <span class="badge bg-success">✓</span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('lecturer/modules/' . $course['id']) ?>" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-folder me-1"></i>Modules
                                </a>
                                <a href="<?= base_url('lecturer/assignments/' . $course['id']) ?>" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-award me-1"></i>Assignments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>No courses assigned to you yet. Please contact the administrator.
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        
        function checkAuth() {
            const token = localStorage.getItem('authToken');
            if (!token) {
                window.location.href = BASE_URL + '/login';
                return false;
            }
            return true;
        }

        function logout() {
            localStorage.removeItem('authToken');
            localStorage.removeItem('currentUser');
            localStorage.removeItem('currentUserRole');
            window.location.href = BASE_URL + '/login';
        }

        document.addEventListener('DOMContentLoaded', checkAuth);
    </script>
</body>
</html>
