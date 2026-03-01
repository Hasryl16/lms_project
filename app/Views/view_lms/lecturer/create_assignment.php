<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assignment - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { width: 260px; min-height: 100vh; background: white; border-right: 1px solid #e5e7eb; }
        .nav-link { border-radius: 0.5rem; padding: 0.75rem 1rem; color: #374151; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: #f3e8ff; color: #9333ea; }
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
                </div>
            </nav>

            <div class="p-3 border-top">
                <a href="#" onclick="logout()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/courses') ?>">My Courses</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/modules/' . $course['id']) ?>"><?= esc($course['title']) ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('lecturer/assignments/' . $module['id']) ?>"><?= esc($module['title']) ?></a></li>
                    <li class="breadcrumb-item active">Create Assignment</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Create New Assignment</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>

                            <form action="<?= base_url('lecturer/createAssignment/' . $module['id']) ?>" method="POST">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Assignment Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="e.g., Final Project" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="4" placeholder="Describe the assignment requirements..."></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Deadline</label>
                                        <input type="datetime-local" class="form-control" name="deadline" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Max Score</label>
                                        <input type="number" class="form-control" name="max_score" value="100" min="1" required>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-1"></i>Create Assignment
                                    </button>
                                    <a href="<?= base_url('lecturer/assignments/' . $module['id']) ?>" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
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
