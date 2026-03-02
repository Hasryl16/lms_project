<?php
// Helper function for grade badge color
function getGradeBadgeColor($grade) {
    if (str_starts_with($grade, 'A')) return 'bg-success';
    if (str_starts_with($grade, 'B')) return 'bg-primary';
    if (str_starts_with($grade, 'C')) return 'bg-warning';
    return 'bg-danger';
}

// Helper function for score color
function getScoreColor($percentage) {
    if ($percentage >= 90) return 'text-success';
    if ($percentage >= 80) return 'text-primary';
    if ($percentage >= 70) return 'text-warning';
    return 'text-danger';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Grades</title>
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
                    <h1 class="h3 fw-bold text-dark">Grades</h1>
                    <p class="text-muted">View your grades and performance</p>
                </div>

                <!-- Overall Grade Stats -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <p class="text-muted small mb-1">Overall Average</p>
                                <h2 class="fw-bold text-primary"><?= $overallAverage ?? 0 ?>%</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <p class="text-muted small mb-1">Letter Grade</p>
                                <h2 class="fw-bold <?= ($overallAverage ?? 0) >= 60 ? 'text-success' : 'text-danger' ?>"><?= $overallLetterGrade ?? 'N/A' ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <p class="text-muted small mb-1">Graded Assignments</p>
                                <h2 class="fw-bold"><?= count($submissions) ?? 0 ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Grades -->
                <div id="gradesContent">
                    <?php if (!empty($courseGrades)): ?>
                        <?php foreach ($courseGrades as $courseId => $course): ?>
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="fw-bold mb-1"><?= $course['course_title'] ?></h5>
                                            <small class="text-muted">Current Grade: <?= $course['percentage'] ?? 0 ?>%</small>
                                        </div>
                                        <span class="badge <?= getGradeBadgeColor($course['letter_grade'] ?? 'N/A') ?> fs-6"><?= $course['letter_grade'] ?? 'N/A' ?></span>
                                    </div>
                                    <div class="progress mt-3" style="height: 8px;">
                                        <div class="progress-bar bg-primary" style="width: <?= $course['percentage'] ?? 0 ?>%"></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-award me-2"></i>Assignment Breakdown</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Assignment</th>
                                                    <th>Score</th>
                                                    <th>Percentage</th>
                                                    <th>Submitted</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($course['submissions'] as $sub): ?>
                                                    <tr>
                                                        <td class="fw-medium"><?= $sub['assignment_title'] ?? 'Assignment' ?></td>
                                                        <td><?= $sub['score'] ?? 0 ?>/<?= $sub['max_score'] ?? 100 ?></td>
                                                        <td>
                                                            <?php 
                                                                $percentage = $sub['max_score'] > 0 ? round(($sub['score'] / $sub['max_score']) * 100) : 0;
                                                            ?>
                                                            <span class="<?= getScoreColor($percentage) ?> fw-medium"><?= $percentage ?>%</span>
                                                        </td>
                                                        <td class="text-muted"><?= date('M d, Y', strtotime($sub['submitted_at'] ?? date('Y-m-d'))) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-award fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No graded assignments yet</p>
                            <a href="<?= base_url('student/assignments') ?>" class="btn btn-primary">View Assignments</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
