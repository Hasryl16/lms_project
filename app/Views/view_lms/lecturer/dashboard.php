<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .stat-card { border: none; border-radius: 1rem; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
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
                    <a href="<?= base_url('lecturer/dashboard') ?>" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('lecturer/courses') ?>" class="nav-link">
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
            <?php 
            $totalStudents = 0;
            $totalPendingGrading = 0;
            if (!empty($courses)) {
                foreach ($courses as $course) {
                    $totalStudents += $course['student_count'] ?? 0;
                    $totalPendingGrading += $course['pending_grading'] ?? 0;
                }
            }
            ?>

            <div class="mb-4">
                <h2 class="fw-bold">Welcome back, <span id="userName"><?= esc($user['name'] ?? 'Lecturer') ?></span>!</h2>
                <p class="text-muted">Here's your teaching overview</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">My Courses</p>
                                    <h3 class="fw-bold mb-0"><?= $totalCourses ?? 0 ?></h3>
                                </div>
                                <div class="p-2 bg-purple-100 rounded">
                                    <i class="bi bi-book text-purple"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">Total Students</p>
                                    <h3 class="fw-bold mb-0"><?= $totalStudents ?></h3>
                                </div>
                                <div class="p-2 bg-blue-100 rounded">
                                    <i class="bi bi-people text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">Pending Grading</p>
                                    <h3 class="fw-bold mb-0<?= $totalPendingGrading > 0 ? ' text-warning' : '' ?>"><?= $totalPendingGrading ?></h3>
                                </div>
                                <div class="p-2 bg-yellow-100 rounded">
                                    <i class="bi bi-file-text text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">Total Modules</p>
                                    <h3 class="fw-bold mb-0"><?= $totalModules ?? 0 ?></h3>
                                </div>
                                <div class="p-2 bg-green-100 rounded">
                                    <i class="bi bi-collection text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">My Courses</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $course): ?>
                                <?php 
                                $pending = $course['pending_grading'] ?? 0;
                                $bgColor = $pending > 0 ? '#fef3c7' : '#dcfce7';
                                ?>
                                <div class="col-md-4">
                                    <div class="p-3 rounded border" style="background: <?= $bgColor ?>;">
                                        <p class="fw-medium mb-1"><?= esc($course['title'] ?? 'Untitled Course') ?></p>
                                        <p class="small text-muted mb-2"><?= $course['student_count'] ?? 0 ?> students enrolled</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <?php if ($pending > 0): ?>
                                                <span class="badge bg-warning"><?= $pending ?> to grade</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">All caught up</span>
                                            <?php endif; ?>
                                            <a href="<?= base_url('lecturer/modules/' . $course['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-4">
                                <p class="text-muted">No courses assigned yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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
