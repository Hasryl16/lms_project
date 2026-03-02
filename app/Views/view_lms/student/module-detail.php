<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - <?= $module->title ?? 'Module Detail' ?></title>
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
                <!-- Module Header -->
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('student/my-courses') ?>">My Courses</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('student/course/' . ($module->course_id ?? '')) ?>"><?= $module->course_title ?? 'Course' ?></a></li>
                            <li class="breadcrumb-item active"><?= $module->title ?? 'Module' ?></li>
                        </ol>
                    </nav>
                    <h1 class="h3 fw-bold text-dark"><?= $module->title ?? 'Module Title' ?></h1>
                    <p class="text-muted"><?= $module->description ?? '' ?></p>
                </div>

                <div class="row g-4">
                    <!-- Materials Section -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-file-earmark-text text-primary me-2"></i>Materials
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($materials)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($materials as $material): ?>
                                            <div class="list-group-item border-0 px-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                                        <span class="fw-medium"><?= $material['title'] ?></span>
                                                    </div>
                                                    <a href="<?= base_url('uploads/' . $material['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No materials available for this module.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Assignments Section -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-file-check text-warning me-2"></i>Assignments
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($assignments)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($assignments as $assignment): ?>
                                            <div class="list-group-item border-0 px-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="fw-medium"><?= $assignment['title'] ?></div>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            Due: <?= isset($assignment['deadline']) ? date('M d, Y', strtotime($assignment['deadline'])) : 'N/A' ?><br>
                                                            <i class="bi bi-star me-1"></i>
                                                            Max Score: <?= $assignment['max_score'] ?? 'N/A' ?>
                                                        </small>
                                                    </div>
                                                    <div class="ms-3">
                                                        <?php if (isset($assignment['submission']) && $assignment['submission']): ?>
                                                            <?php if ($assignment['submission']['score'] !== null): ?>
                                                                <span class="badge bg-success">
                                                                    <i class="bi bi-check-circle me-1"></i>
                                                                    <?= $assignment['submission']['score'] ?>/<?= $assignment['max_score'] ?? 'N/A' ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">
                                                                    <i class="bi bi-clock me-1"></i>Submitted
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#submitModal" data-assignment-id="<?= $assignment['id'] ?>" data-assignment-title="<?= $assignment['title'] ?>">
                                                                Submit
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No assignments for this module.</p>
                                <?php endif; ?>
                            </div>
                        </div>
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
                    <h5 class="modal-title">Submit Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="assignmentTitle" class="fw-bold"></p>
                    <input type="hidden" id="assignmentId">
                    <div class="mb-3">
                        <label class="form-label">Your Answer</label>
                        <textarea class="form-control" id="answerText" rows="6" placeholder="Enter your answer here..."></textarea>
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
        
        function getJwtToken() {
            return localStorage.getItem('authToken') || '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
            
            document.getElementById('submitModal').addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('assignmentId').value = button.getAttribute('data-assignment-id');
                document.getElementById('assignmentTitle').textContent = button.getAttribute('data-assignment-title');
            });
        });

        function submitAssignment() {
            const assignmentId = document.getElementById('assignmentId').value;
            const answerText = document.getElementById('answerText').value;
            
            if (!answerText.trim()) {
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
                    alert(data.message);
                    submitModal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert(data.message || 'Failed to submit assignment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    </script>
</body>
</html>
