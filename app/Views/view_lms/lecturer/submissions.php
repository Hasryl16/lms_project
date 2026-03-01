<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: white;
            border-right: 1px solid #e5e7eb;
        }
        .nav-link {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: #374151;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background: #f3e8ff;
            color: #9333ea;
        }
        .submission-card {
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .submission-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
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
                    <a href="<?= base_url('lecturer/assignments/' . $course['id']) ?>" class="nav-link">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                </div>
            </nav>

            <div class="p-3 border-top">
                <a href="#" onclick="logout()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/courses') ?>">My Courses</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/assignments/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($assignment['title']) ?></li>
                </ol>
            </nav>

            <div class="mb-4">
                <h2 class="fw-bold"><?= esc($assignment['title']) ?></h2>
                <p class="text-muted"><?= esc($course['title']) ?> - Submissions</p>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Stats -->
            <?php
            $totalSubmissions = count($submissions);
            $gradedCount = 0;
            $pendingCount = 0;
            foreach ($submissions as $sub) {
                if ($sub['score'] !== null) {
                    $gradedCount++;
                } else {
                    $pendingCount++;
                }
            }
            ?>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Submissions</p>
                            <h4 class="fw-bold mb-0"><?= $totalSubmissions ?></h4>
                        </div>
                    </div>
                </div>
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
                            <p class="text-muted small mb-1">Max Score</p>
                            <h4 class="fw-bold mb-0"><?= esc($assignment['max_score']) ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-4" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pending">
                        <i class="bi bi-hourglass-split me-1"></i>Pending (<?= $pendingCount ?>)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#graded">
                        <i class="bi bi-check-circle me-1"></i>Graded (<?= $gradedCount ?>)
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Pending Submissions -->
                <div class="tab-pane fade show active" id="pending">
                    <?php 
                    $hasPending = false;
                    foreach ($submissions as $submission): 
                        if ($submission['score'] === null):
                            $hasPending = true;
                    ?>
                    <div class="card submission-card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?= esc($submission['student_name']) ?></h6>
                                    <p class="small text-muted mb-0"><?= esc($submission['student_email']) ?></p>
                                </div>
                                <span class="badge bg-warning">Pending</span>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-6 col-md-3">
                                    <small class="text-muted">Submitted</small>
                                    <p class="mb-0"><?= date('Y-m-d H:i', strtotime($submission['submitted_at'])) ?></p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <?php if ($submission['file_path']): ?>
                                <a href="<?= base_url('writable/uploads/' . $submission['file_path']) ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-download me-1"></i>View Submission
                                </a>
                                <?php endif; ?>
                                <?php if ($submission['answer_text']): ?>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#answerModal<?= $submission['id'] ?>">
                                    <i class="bi bi-file-text me-1"></i>View Answer
                                </button>
                                <?php endif; ?>
                                <a href="<?= base_url('lecturer/gradeSubmission/' . $submission['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-award me-1"></i>Grade Now
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Answer Modal -->
                    <?php if ($submission['answer_text']): ?>
                    <div class="modal fade" id="answerModal<?= $submission['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= esc($submission['student_name']) ?>'s Answer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <pre style="white-space: pre-wrap;"><?= esc($submission['answer_text']) ?></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php if (!$hasPending): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle text-success fs-1 d-block mb-3"></i>
                        <h5>All submissions graded!</h5>
                        <p class="text-muted">There are no pending submissions to grade.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Graded Submissions -->
                <div class="tab-pane fade" id="graded">
                    <?php 
                    $hasGraded = false;
                    foreach ($submissions as $submission): 
                        if ($submission['score'] !== null):
                            $hasGraded = true;
                            $percentage = round(($submission['score'] / $assignment['max_score']) * 100);
                    ?>
                    <div class="card submission-card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?= esc($submission['student_name']) ?></h6>
                                    <p class="small text-muted mb-0"><?= esc($submission['student_email']) ?></p>
                                </div>
                                <div class="text-end">
                                    <span class="h4 mb-0 text-purple"><?= $submission['score'] ?>/<?= $assignment['max_score'] ?></span>
                                    <small class="d-block text-muted"><?= $percentage ?>%</small>
                                </div>
                            </div>
                            <?php if ($submission['feedback']): ?>
                            <div class="mt-2 p-2 bg-light rounded">
                                <small class="text-muted">Feedback:</small>
                                <p class="mb-0 small"><?= esc($submission['feedback']) ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="d-flex gap-2 mt-3">
                                <?php if ($submission['file_path']): ?>
                                <a href="<?= base_url('writable/uploads/' . $submission['file_path']) ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-download me-1"></i>View Submission
                                </a>
                                <?php endif; ?>
                                <a href="<?= base_url('lecturer/gradeSubmission/' . $submission['id']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Edit Grade
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php if (!$hasGraded): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted fs-1 d-block mb-3"></i>
                        <h5>No graded submissions yet</h5>
                        <p class="text-muted">Submissions will appear here once graded.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        
        function logout() {
            localStorage.removeItem('authToken');
            localStorage.removeItem('currentUser');
            localStorage.removeItem('currentUserRole');
            window.location.href = BASE_URL + '/login';
        }
    </script>
</body>
</html>
