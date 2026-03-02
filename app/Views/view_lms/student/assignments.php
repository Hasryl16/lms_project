<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Assignments</title>
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
                    <h1 class="h3 fw-bold text-dark">Assignments</h1>
                    <p class="text-muted">View and submit your assignments</p>
                </div>

                <!-- Assignment Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="fw-bold text-warning"><?= count($pending) ?? 0 ?></h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="fw-bold text-primary"><?= count($submitted) ?? 0 ?></h3>
                                <p class="text-muted mb-0">Submitted</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="fw-bold text-success"><?= count($graded) ?? 0 ?></h3>
                                <p class="text-muted mb-0">Graded</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Assignments -->
                <div class="mb-4">
                    <h5 class="fw-bold">Pending Assignments</h5>
                    <div class="row g-3" id="pendingAssignmentsGrid">
                        <?php if (!empty($pending)): ?>
                            <?php foreach ($pending as $assignment): ?>
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-secondary"><?= $assignment['course_title'] ?? 'Course' ?></span>
                                                <span class="badge bg-warning">Pending</span>
                                            </div>
                                            <h5 class="card-title fw-bold"><?= $assignment['title'] ?? 'Assignment' ?></h5>
                                            <p class="card-text text-muted small"><?= $assignment['description'] ?? '' ?></p>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i>Due: <?= date('M d, Y', strtotime($assignment['due_date'] ?? date('Y-m-d'))) ?></small>
                                                <span class="fw-medium"><?= $assignment['max_score'] ?? 100 ?> points</span>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <button class="btn btn-primary flex-grow-1" onclick="openSubmitModal(<?= $assignment['id'] ?>, '<?= addslashes($assignment['title'] ?? 'Assignment') ?>')">
                                                <i class="bi bi-upload me-2"></i>Submit Assignment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-3">
                                <p class="text-muted">No pending assignments</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Submitted Assignments -->
                <div class="mb-4">
                    <h5 class="fw-bold">Submitted Assignments</h5>
                    <div class="row g-3" id="submittedAssignmentsGrid">
                        <?php if (!empty($submitted)): ?>
                            <?php foreach ($submitted as $assignment): ?>
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-secondary"><?= $assignment['course_title'] ?? 'Course' ?></span>
                                                <span class="badge bg-primary">Submitted</span>
                                            </div>
                                            <h5 class="card-title fw-bold"><?= $assignment['title'] ?? 'Assignment' ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="p-2 bg-primary bg-opacity-10 rounded">
                                                <small class="text-primary">Submitted on <?= date('M d, Y', strtotime($assignment['submission']['submitted_at'] ?? date('Y-m-d'))) ?> - Awaiting grading</small>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <button class="btn btn-outline-secondary w-100" disabled>
                                                <i class="bi bi-check-circle me-2"></i>Submitted - Awaiting Grade
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-3">
                                <p class="text-muted">No submitted assignments</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Graded Assignments -->
                <div class="mb-4">
                    <h5 class="fw-bold">Graded Assignments</h5>
                    <div class="row g-3" id="gradedAssignmentsGrid">
                        <?php if (!empty($graded)): ?>
                            <?php foreach ($graded as $assignment): ?>
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-secondary"><?= $assignment['course_title'] ?? 'Course' ?></span>
                                                <span class="badge bg-success">Graded</span>
                                            </div>
                                            <h5 class="card-title fw-bold"><?= $assignment['title'] ?? 'Assignment' ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="p-2 bg-success bg-opacity-10 rounded mb-2">
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Submitted on <?= date('M d, Y', strtotime($assignment['submission']['submitted_at'] ?? date('Y-m-d'))) ?></small>
                                                    <span class="fw-bold text-success"><?= $assignment['submission']['score'] ?? 0 ?>/<?= $assignment['max_score'] ?? 100 ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <a href="<?= base_url('student/grades') ?>" class="btn btn-outline-primary w-100">
                                                <i class="bi bi-award me-2"></i>View Grade
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-3">
                                <p class="text-muted">No graded assignments</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Submit Assignment Modal -->
    <div class="modal fade" id="submitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Assignment: <span id="submitAssignmentTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="submitAssignmentId">
                    <div class="mb-3">
                        <label for="submissionText" class="form-label">Your Answer</label>
                        <textarea class="form-control" id="submissionText" rows="6" placeholder="Enter your answer here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitAssignment()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let submitModal;
        
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
            submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
        });

        function openSubmitModal(assignmentId, title) {
            document.getElementById('submitAssignmentId').value = assignmentId;
            document.getElementById('submitAssignmentTitle').textContent = title;
            document.getElementById('submissionText').value = '';
            submitModal.show();
        }

        function submitAssignment() {
            const assignmentId = document.getElementById('submitAssignmentId').value;
            const answerText = document.getElementById('submissionText').value.trim();
            
            if (!answerText) {
                alert('Please enter your answer');
                return;
            }
            
            const formData = new FormData();
            formData.append(getCsrfTokenName(), getCsrfToken());
            formData.append('answer_text', answerText);

            const jwtToken = getJwtToken();
            
            fetch(`<?= base_url('student/submit-assignment/') ?>${assignmentId}`, {
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
                    submitModal.hide();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert(data.message || 'Failed to submit');
                }
            })
            .catch(error => {
                alert('An error occurred');
            });
        }
    </script>
</body>
</html>
