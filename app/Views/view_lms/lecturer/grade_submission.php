<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Submission - LMS</title>
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
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/submissions/' . $submission['assignment_id']) ?>">Submissions</a></li>
                    <li class="breadcrumb-item active">Grade</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Grade Submission</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('lecturer/gradeSubmission/' . $submission['id']) ?>" method="POST">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                <div class="mb-4">
                                    <div class="p-3 bg-light rounded mb-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-1">Student Name</p>
                                                <p class="fw-medium mb-0"><?= esc($student['name'] ?? 'Unknown') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-1">Email</p>
                                                <p class="fw-medium mb-0"><?= esc($student['email'] ?? 'Unknown') ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-1">Assignment</p>
                                                <p class="fw-medium mb-0"><?= esc($submission['assignment_title']) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-1">Submitted</p>
                                                <p class="fw-medium mb-0"><?= date('Y-m-d H:i', strtotime($submission['submitted_at'])) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Student Answer -->
                                    <?php if ($submission['answer_text']): ?>
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Student's Answer</label>
                                        <div class="p-3 border rounded" style="max-height: 200px; overflow-y: auto;">
                                            <pre style="white-space: pre-wrap; font-family: inherit;"><?= esc($submission['answer_text']) ?></pre>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- File -->
                                    <?php if ($submission['file_path']): ?>
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Submitted File</label>
                                        <div class="p-3 border rounded">
                                            <a href="<?= base_url('writable/uploads/' . $submission['file_path']) ?>" target="_blank" class="btn btn-outline-primary">
                                                <i class="bi bi-download me-1"></i>Download Submission
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Grade Input -->
                                <div class="mb-3">
                                    <label class="form-label">Score (out of <?= esc($submission['max_score']) ?>)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="score" id="scoreInput" 
                                               value="<?= $submission['score'] ?? '' ?>" 
                                               min="0" max="<?= esc($submission['max_score']) ?>" 
                                               oninput="updatePercentage()" required>
                                        <span class="input-group-text">/ <?= esc($submission['max_score']) ?></span>
                                    </div>
                                    <div class="form-text">Percentage: <span id="percentageDisplay">0</span>%</div>
                                </div>

                                <!-- Feedback -->
                                <div class="mb-4">
                                    <label class="form-label">Feedback</label>
                                    <textarea class="form-control" name="feedback" rows="5" placeholder="Provide constructive feedback to the student..."><?= $submission['feedback'] ?? '' ?></textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i>Save Grade
                                    </button>
                                    <a href="<?= base_url('lecturer/submissions/' . $submission['assignment_id']) ?>" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h6 class="mb-0 fw-bold">Assignment Details</h6>
                        </div>
                        <div class="card-body">
                            <?php
                            $db = \Config\Database::connect();
                            $assignment = $db->table('assignments')
                                ->where('id', $submission['assignment_id'])
                                ->get()
                                ->getRowArray();
                            ?>
                            <div class="mb-3">
                                <small class="text-muted d-block">Title</small>
                                <p class="mb-0"><?= esc($assignment['title'] ?? '-') ?></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Description</small>
                                <p class="mb-0"><?= esc($assignment['description'] ?? '-') ?></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Deadline</small>
                                <p class="mb-0"><?= date('Y-m-d H:i', strtotime($assignment['deadline'])) ?></p>
                            </div>
                            <div class="mb-0">
                                <small class="text-muted d-block">Max Score</small>
                                <p class="mb-0"><?= esc($assignment['max_score']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        const maxScore = <?= esc($submission['max_score']) ?>;
        
        function logout() {
            localStorage.removeItem('authToken');
            localStorage.removeItem('currentUser');
            localStorage.removeItem('currentUserRole');
            window.location.href = BASE_URL + '/login';
        }
        
        function updatePercentage() {
            const score = parseInt(document.getElementById('scoreInput').value) || 0;
            const percentage = Math.round((score / maxScore) * 100);
            document.getElementById('percentageDisplay').textContent = percentage;
        }
        
        // Initialize percentage on load
        document.addEventListener('DOMContentLoaded', updatePercentage);
    </script>
</body>
</html>
