<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .module-card { border-radius: 0.75rem; transition: transform 0.2s, box-shadow 0.2s; }
        .module-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
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
                    <a href="<?= base_url('lecturer/all-modules') ?>" class="nav-link active">
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
                    <h2 class="fw-bold">Modules</h2>
                    <p class="text-muted">
                        <?php if (isset($course)): ?>
                            <?= esc($course['title']) ?>
                        <?php else: ?>
                            All Modules Across Your Courses
                        <?php endif; ?>
                    </p>
                </div>
                <?php if (isset($course)): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moduleModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Module
                </button>
                <?php endif; ?>
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

            <?php if (!empty($modules)): ?>
            <div class="row g-3">
                <?php foreach ($modules as $index => $module): ?>
                <div class="col-md-6">
                    <div class="card module-card h-100">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="badge bg-secondary mb-2">Module <?= $index + 1 ?></span>
                                    <?php if (isset($module['course_title'])): ?>
                                        <span class="badge bg-purple ms-1" style="background: #9333ea;"><?= esc($module['course_title']) ?></span>
                                    <?php endif; ?>
                                    <h5 class="fw-bold mb-1 mt-2"><?= esc($module['title']) ?></h5>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('lecturer/materials/' . $module['id']) ?>">
                                            <i class="bi bi-folder me-2"></i>View Materials
                                        </a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('lecturer/createAssignment/' . $module['id']) ?>">
                                            <i class="bi bi-file-plus me-2"></i>Add Assignment
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteModule(<?= $module['id'] ?>)">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted"><?= esc($module['description'] ?? 'No description') ?></p>
                            
                            <?php 
                            $materialCount = $module['material_count'] ?? 0;
                            $assignmentCount = $module['assignment_count'] ?? 0;
                            ?>
                            
                            <div class="row g-2 mt-2">
                                <div class="col-6">
                                    <div class="p-2 rounded" style="background: #f3e8ff;">
                                        <small class="text-muted d-block">Materials</small>
                                        <strong><?= $materialCount ?></strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded" style="background: #dbeafe;">
                                        <small class="text-muted d-block">Assignments</small>
                                        <strong><?= $assignmentCount ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('lecturer/materials/' . $module['id']) ?>" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-folder me-1"></i>Materials
                                </a>
                                <a href="<?= base_url('lecturer/createAssignment/' . $module['id']) ?>" class="btn btn-outline-primary flex-grow-1">
                                    <i class="bi bi-file-plus me-1"></i>Assignment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-collection text-muted fs-1 d-block mb-3"></i>
                    <h5>No modules yet</h5>
                    <p class="text-muted">Start by adding modules to organize your course content.</p>
                    <?php if (isset($course)): ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moduleModal">
                        <i class="bi bi-plus-lg me-1"></i>Add First Module
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <?php if (isset($course)): ?>
    <div class="modal fade" id="moduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('lecturer/createModule/' . $course['id']) ?>" method="POST">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Module Title</label>
                            <input type="text" class="form-control" name="title" placeholder="e.g., Introduction to HTML" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" placeholder="Describe what students will learn in this module"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Module</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

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

        function deleteModule(moduleId) {
            if (confirm('Are you sure you want to delete this module? All materials and assignments within this module will also be deleted.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = BASE_URL + '/lecturer/deleteModule/' + moduleId;
                
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
