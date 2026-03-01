<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materials - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
        .material-card { border-radius: 0.75rem; transition: transform 0.2s, box-shadow 0.2s; }
        .material-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
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
                    <a href="<?= base_url('lecturer/all-materials') ?>" class="nav-link active">
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
            <?php if (isset($course) && isset($module)): ?>
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/courses') ?>">My Courses</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/modules/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($module['title']) ?></li>
                </ol>
            </nav>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Materials</h2>
                    <p class="text-muted">
                        <?php if (isset($course) && isset($module)): ?>
                            <?= esc($module['title']) ?> - <?= esc($course['title']) ?>
                        <?php else: ?>
                            All Materials Across Your Courses
                        <?php endif; ?>
                    </p>
                </div>
                <?php if (isset($module)): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materialModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Material
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

            <?php if (!empty($materials)): ?>
            <div class="row g-3">
                <?php foreach ($materials as $material): ?>
                <div class="col-md-6">
                    <div class="card material-card h-100">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2">
                                    <?php
                                    $iconClass = 'bi-file-earmark-text';
                                    $badgeClass = 'bg-secondary';
                                    if (strpos(strtolower($material['type'] ?? ''), 'pdf') !== false) {
                                        $iconClass = 'bi-file-earmark-pdf';
                                        $badgeClass = 'bg-danger';
                                    } elseif (strpos(strtolower($material['type'] ?? ''), 'video') !== false) {
                                        $iconClass = 'bi-play-circle';
                                        $badgeClass = 'bg-primary';
                                    } elseif (strpos(strtolower($material['type'] ?? ''), 'image') !== false) {
                                        $iconClass = 'bi-file-earmark-image';
                                        $badgeClass = 'bg-success';
                                    }
                                    ?>
                                    <i class="bi <?= $iconClass ?> text-muted mt-1"></i>
                                    <div>
                                        <h6 class="mb-0"><?= esc($material['title']) ?></h6>
                                        <?php if (isset($material['module_title'])): ?>
                                            <small class="text-purple"><?= esc($material['module_title']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <span class="badge <?= $badgeClass ?>"><?= esc($material['type'] ?? 'file') ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between small text-muted mb-2">
                                <span>Uploaded: <?= date('Y-m-d', strtotime($material['uploaded_at'] ?? date('Y-m-d'))) ?></span>
                                <?php if (isset($material['course_title'])): ?>
                                    <span class="badge bg-light text-dark"><?= esc($material['course_title']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <?php if (!empty($material['file_path'])): ?>
                                <a href="<?= base_url('writable/uploads/' . $material['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-download me-1"></i>View
                                </a>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteMaterial(<?= $material['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder text-muted fs-1 d-block mb-3"></i>
                    <h5>No materials yet</h5>
                    <p class="text-muted">Start by adding learning materials to your modules.</p>
                    <?php if (isset($module)): ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materialModal">
                        <i class="bi bi-plus-lg me-1"></i>Add First Material
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <?php if (isset($module)): ?>
    <div class="modal fade" id="materialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('lecturer/createMaterial/' . $module['id']) ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Material Title</label>
                            <input type="text" class="form-control" name="title" placeholder="e.g., Lecture Notes Chapter 1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Material Type</label>
                            <select class="form-select" name="type" required>
                                <option value="">Select type...</option>
                                <option value="application/pdf">PDF Document</option>
                                <option value="application/vnd.ms-powerpoint">Powerpoint</option>
                                <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document">Word Document</option>
                                <option value="video/mp4">Video</option>
                                <option value="image/jpeg">Image</option>
                                <option value="text/plain">Text File</option>
                                <option value="application/zip">ZIP Archive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload File</label>
                            <input type="file" class="form-control" name="file" required>
                            <div class="form-text">Max file size: 10MB</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload Material</button>
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

        function logout() {
            localStorage.removeItem('authToken');
            localStorage.removeItem('currentUser');
            localStorage.removeItem('currentUserRole');
            window.location.href = BASE_URL + '/login';
        }

        function deleteMaterial(materialId) {
            if (confirm('Are you sure you want to delete this material?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = BASE_URL + '/lecturer/deleteMaterial/' + materialId;
                
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
