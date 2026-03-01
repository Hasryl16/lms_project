<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .submission-card { border-radius: 0.75rem; transition: transform 0.2s, box-shadow 0.2s; }
        .submission-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
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
            <div class="mb-4">
                <h2 class="fw-bold">Grading</h2>
                <p class="text-muted">Review and grade student submissions</p>
            </div>

            <?php 
            $pendingCount = 0;
            $gradedCount = 0;
            $totalScore = 0;
            $gradedCountForAvg = 0;
            
            if (!empty($submissions)) {
                foreach ($submissions as $sub) {
                    if ($sub['score'] === null) {
                        $pendingCount++;
                    } else {
                        $gradedCount++;
                        $totalScore += ($sub['score'] / $sub['max_score']) * 100;
                        $gradedCountForAvg++;
                    }
                }
            }
            $avgGrade = $gradedCountForAvg > 0 ? round($totalScore / $gradedCountForAvg) : 0;
            ?>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Pending Grading</p>
                            <h4 class="fw-bold mb-0 text-warning"><?= $pendingCount ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Graded</p>
                            <h4 class="fw-bold mb-0 text-success"><?= $gradedCount ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Submissions</p>
                            <h4 class="fw-bold mb-0"><?= $pendingCount + $gradedCount ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Average Grade</p>
                            <h4 class="fw-bold mb-0"><?= $avgGrade ?>%</h4>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills mb-4" id="gradingTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pending" type="button">
                        <i class="bi bi-hourglass-split me-1"></i>Pending (<?= $pendingCount ?>)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#graded" type="button">
                        <i class="bi bi-check-circle me-1"></i>Graded (<?= $gradedCount ?>)
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="pending">
                    <div class="row g-3">
                        <?php if (empty($submissions)): ?>
                            <div class="col-12 text-center py-4">
                                <p class="text-muted">No pending submissions.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($submissions as $sub): ?>
                                <?php if ($sub['score'] === null): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card submission-card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <h6 class="mb-1"><?= $sub['student_name'] ?></h6>
                                                        <p class="small text-muted mb-0"><?= $sub['student_email'] ?></p>
                                                    </div>
                                                    <span class="badge bg-warning">Pending</span>
                                                </div>
                                                <div class="small mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Assignment:</span>
                                                        <span class="fw-medium"><?= $sub['assignment_title'] ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Course:</span>
                                                        <span class="fw-medium"><?= $sub['course_title'] ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Submitted:</span>
                                                        <span class="fw-medium"><?= date('Y-m-d', strtotime($sub['submitted_at'])) ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Max Points:</span>
                                                        <span class="fw-medium"><?= $sub['max_score'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <?php if ($sub['file_path']): ?>
                                                        <a href="<?= base_url($sub['file_path']) ?>" class="btn btn-outline-secondary btn-sm flex-grow-1" download>
                                                            <i class="bi bi-download me-1"></i>Download
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?= base_url('lecturer/gradeSubmission/' . $sub['id']) ?>" class="btn btn-primary btn-sm flex-grow-1">
                                                        Grade Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="graded">
                    <div class="row g-3">
                        <?php if (empty($submissions)): ?>
                            <div class="col-12 text-center py-4">
                                <p class="text-muted">No graded submissions.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($submissions as $sub): ?>
                                <?php if ($sub['score'] !== null): ?>
                                    <?php 
                                        $percentage = round(($sub['score'] / $sub['max_score']) * 100);
                                    ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card submission-card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <h6 class="mb-1"><?= $sub['student_name'] ?></h6>
                                                        <p class="small text-muted mb-0"><?= $sub['student_email'] ?></p>
                                                    </div>
                                                    <span class="badge bg-success">Graded</span>
                                                </div>
                                                <div class="text-end mb-3">
                                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                                        <i class="bi bi-award text-purple"></i>
                                                        <span class="h4 mb-0 text-purple"><?= $sub['score'] ?>/<?= $sub['max_score'] ?></span>
                                                    </div>
                                                    <small class="text-muted"><?= $percentage ?>%</small>
                                                </div>
                                                <div class="small mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Assignment:</span>
                                                        <span class="fw-medium"><?= $sub['assignment_title'] ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Course:</span>
                                                        <span class="fw-medium"><?= $sub['course_title'] ?></span>
                                                    </div>
                                                </div>
                                                <?php if (!empty($sub['feedback'])): ?>
                                                    <div class="p-2 bg-light rounded small mb-3">
                                                        <p class="fw-medium mb-1">Feedback:</p>
                                                        <p class="text-muted mb-0"><?= $sub['feedback'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="d-flex gap-2">
                                                    <?php if ($sub['file_path']): ?>
                                                        <a href="<?= base_url($sub['file_path']) ?>" class="btn btn-outline-secondary btn-sm flex-grow-1" download>
                                                            <i class="bi bi-download me-1"></i>Download
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?= base_url('lecturer/gradeSubmission/' . $sub['id']) ?>" class="btn btn-outline-primary btn-sm flex-grow-1">
                                                        Edit Grade
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
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
