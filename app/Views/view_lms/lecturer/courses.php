<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - LMS</title>
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
        .course-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .stat-box {
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
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
                    <a href="dashboard.html" class="nav-link">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="courses.html" class="nav-link active">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="materials.html" class="nav-link">
                        <i class="bi bi-folder me-2"></i>Materials
                    </a>
                    <a href="assignments.html" class="nav-link">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="grading.html" class="nav-link">
                        <i class="bi bi-award me-2"></i>Grading
                    </a>
                </div>
            </nav>

            <div class="p-3 border-top">
                <a href="../login.html" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
            <div class="mb-4">
                <h2 class="fw-bold">My Courses</h2>
                <p class="text-muted">Manage your teaching courses</p>
            </div>

            <!-- Summary Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Courses</p>
                            <h3 class="fw-bold mb-0">3</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Students</p>
                            <h3 class="fw-bold mb-0">466</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Pending Grading</p>
                            <h3 class="fw-bold mb-0">17</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Cards -->
            <div class="row g-4">
                <!-- Course 1 -->
                <div class="col-lg-6">
                    <div class="card course-card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-bold mb-1">Web Development Fundamentals</h5>
                            <p class="text-muted small mb-0">Learn HTML, CSS, and JavaScript basics</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dbeafe;">
                                        <i class="bi bi-people text-primary d-block mb-1"></i>
                                        <strong>245</strong>
                                        <p class="small mb-0 text-muted">Students</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dcfce7;">
                                        <i class="bi bi-book text-success d-block mb-1"></i>
                                        <strong>12/12</strong>
                                        <p class="small mb-0 text-muted">Modules</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #f3e8ff;">
                                        <i class="bi bi-award text-purple d-block mb-1"></i>
                                        <strong>87%</strong>
                                        <p class="small mb-0 text-muted">Avg Grade</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Course Progress</span>
                                    <span class="fw-medium">100%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>

                            <div class="p-3 rounded border" style="background: #fef3c7;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small fw-medium mb-0">12 submissions awaiting grading</p>
                                    <span class="badge bg-warning">Action needed</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="materials.html?course=1" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-folder me-1"></i>Materials
                                </a>
                                <a href="grading.html?course=1" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-award me-1"></i>Grade
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="col-lg-6">
                    <div class="card course-card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-bold mb-1">Advanced JavaScript</h5>
                            <p class="text-muted small mb-0">Master advanced JavaScript concepts and modern frameworks</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dbeafe;">
                                        <i class="bi bi-people text-primary d-block mb-1"></i>
                                        <strong>132</strong>
                                        <p class="small mb-0 text-muted">Students</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dcfce7;">
                                        <i class="bi bi-book text-success d-block mb-1"></i>
                                        <strong>7/10</strong>
                                        <p class="small mb-0 text-muted">Modules</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #f3e8ff;">
                                        <i class="bi bi-award text-purple d-block mb-1"></i>
                                        <strong>82%</strong>
                                        <p class="small mb-0 text-muted">Avg Grade</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Course Progress</span>
                                    <span class="fw-medium">70%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" style="width: 70%;"></div>
                                </div>
                            </div>

                            <div class="p-3 rounded border" style="background: #dcfce7;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small fw-medium mb-0 text-success">All caught up</p>
                                    <span class="badge bg-success">✓</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="materials.html?course=2" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-folder me-1"></i>Materials
                                </a>
                                <a href="grading.html?course=2" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-award me-1"></i>Grade
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="col-lg-6">
                    <div class="card course-card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-bold mb-1">React Advanced Topics</h5>
                            <p class="text-muted small mb-0">Deep dive into React patterns and performance optimization</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dbeafe;">
                                        <i class="bi bi-people text-primary d-block mb-1"></i>
                                        <strong>89</strong>
                                        <p class="small mb-0 text-muted">Students</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #dcfce7;">
                                        <i class="bi bi-book text-success d-block mb-1"></i>
                                        <strong>5/8</strong>
                                        <p class="small mb-0 text-muted">Modules</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box" style="background: #f3e8ff;">
                                        <i class="bi bi-award text-purple d-block mb-1"></i>
                                        <strong>85%</strong>
                                        <p class="small mb-0 text-muted">Avg Grade</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Course Progress</span>
                                    <span class="fw-medium">63%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" style="width: 63%;"></div>
                                </div>
                            </div>

                            <div class="p-3 rounded border" style="background: #fef3c7;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small fw-medium mb-0">5 submissions awaiting grading</p>
                                    <span class="badge bg-warning">Action needed</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex gap-2">
                                <a href="materials.html?course=3" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-folder me-1"></i>Materials
                                </a>
                                <a href="grading.html?course=3" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-award me-1"></i>Grade
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
