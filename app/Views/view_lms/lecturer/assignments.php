<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .assignment-card { border-radius: 0.75rem; transition: transform 0.2s, box-shadow 0.2s; }
        .assignment-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
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
                    <a href="<?= base_url('lecturer/all-assignments') ?>" class="nav-link active">
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
            <?php if (isset($course)): ?>
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/courses') ?>">My Courses</a></li>
                    <li class="breadcrumb-item active"><?= esc($course['title']) ?></li>
                </ol>
            </nav>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Assignments</h2>
                    <p class="text-muted">
                        <?php if (isset($course)): ?>
                            <?= esc($course['title']) ?>
                        <?php else: ?>
                            All Assignments Across Your Courses
                        <?php endif; ?>
                    </p>
                </div>
            </div>

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

            <?php if (!empty($assignments)): ?>
            <div class="d-flex flex-column gap-3">
                <?php 
                $db = \Config\Database::connect();
                foreach ($assignments as $assignment): 
                    // Get submission stats
                    $totalSubmissions = $db->table('submissions')
                        ->where('assignment_id', $assignment['id'])
                        ->countAllResults();
                    $gradedSubmissions = $db->table('submissions')
                        ->where('assignment_id', $assignment['id'])
                        ->where('score IS NOT NULL')
                        ->countAllResults();
                    $pendingGrading = $totalSubmissions - $gradedSubmissions;
                ?>
                <div class="card assignment-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h6 class="mb-0"><?= esc($assignment['title']) ?></h6>
                                    <?php if ($pendingGrading > 0): ?>
                                    <span class="badge bg-warning"><?= $pendingGrading ?> to grade</span>
                                    <?php else: ?>
                                    <span class="badge bg-success">All Graded</span>
                                    <?php endif; ?>
                                </div>
                                <p class="small text-muted mb-0"><?= esc($assignment['description'] ?? 'No description') ?></p>
                                <p class="small text-muted mb-0 mt-1">
                                    <i class="bi bi-collection me-1"></i><?= esc($assignment['module_title'] ?? 'Unknown Module') ?>
                                    <?php if (isset($assignment['course_title'])): ?>
                                        <span class="badge bg-purple ms-1" style="background: #9333ea;"><?= esc($assignment['course_title']) ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6 col-md-3">
                                <div class="small">
                                    <p class="text-muted mb-0">Due Date</p>
                                    <p class="fw-medium mb-0"><?= date('Y-m-d', strtotime($assignment['deadline'])) ?></p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="small">
                                    <p class="text-muted mb-0">Points</p>
                                    <p class="fw-medium mb-0"><?= esc($assignment['max_score']) ?></p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="small">
                                    <p class="text-muted mb-0">Submissions</p>
                                    <p class="fw-medium mb-0"><?= $totalSubmissions ?></p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="small">
                                    <p class="text-muted mb-0">Graded</p>
                                    <p class="fw-medium mb-0"><?= $gradedSubmissions ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ($totalSubmissions > 0): ?>
                            <a href="<?= base_url('lecturer/submissions/' . $assignment['id']) ?>" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-award me-1"></i>Grade Submissions (<?= $pendingGrading ?>)
                            </a>
                            <?php else: ?>
                            <button class="btn btn-outline-secondary flex-grow-1" disabled>
                                <i class="bi bi-inbox me-1"></i>No Submissions
                            </button>
                            <?php endif; ?>
                            <a href="<?= base_url('lecturer/updateAssignment/' . $assignment['id']) ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-outline-danger" onclick="deleteAssignment(<?= $assignment['id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-text text-muted fs-1 d-block mb-3"></i>
                    <h5>No assignments yet</h5>
                    <p class="text-muted">Create your first assignment to get started.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        const CSRF_TOKEN = '<?= csrf_token() ?>';
        const CSRF_HASH = '<?= csrf_hash() ?>';
        
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

        function deleteAssignment(assignmentId) {
            if (confirm('Are you sure you want to delete this assignment? All submissions will also be deleted.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = BASE_URL + '/lecturer/deleteAssignment/' + assignmentId;
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = CSRF_TOKEN;
                csrfInput.value = CSRF_HASH;
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', checkAuth);
    </script>
</body>
</html>
