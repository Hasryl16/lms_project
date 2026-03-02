<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - LMS</title>
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
        .stat-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .course-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
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
                    <a href="/lecturer/dashboard" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="/lecturer/courses" class="nav-link">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="/lecturer/materials" class="nav-link">
                        <i class="bi bi-folder me-2"></i>Materials
                    </a>
                    <a href="/lecturer/assignments" class="nav-link">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="/lecturer/grading" class="nav-link">
                        <i class="bi bi-award me-2"></i>Grading
                    </a>
                </div>
            </nav>

            <div class="p-3 border-top">
                <a href="/login" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
            <div class="mb-4">
                <h2 class="fw-bold">Welcome back, Dr. Smith!</h2>
                <p class="text-muted">Here's your teaching overview</p>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">My Courses</p>
                                    <h3 class="fw-bold mb-0">3</h3>
                                </div>
                                <div class="p-2 bg-purple-100 rounded">
                                    <i class="bi bi-book text-purple"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">Total Students</p>
                                    <h3 class="fw-bold mb-0">456</h3>
                                </div>
                                <div class="p-2 bg-blue-100 rounded">
                                    <i class="bi bi-people text-blue"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">Pending Grading</p>
                                    <h3 class="fw-bold mb-0">12</h3>
                                </div>
                                <div class="p-2 bg-yellow-100 rounded">
                                    <i class="bi bi-file-text text-yellow"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted small mb-1">This Week's Classes</p>
                                    <h3 class="fw-bold mb-0">8</h3>
                                </div>
                                <div class="p-2 bg-green-100 rounded">
                                    <i class="bi bi-clock text-green"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Upcoming Classes -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 fw-bold">Upcoming Classes</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div class="p-3 rounded border" style="background: #f3e8ff;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="fw-medium mb-1">Web Development Fundamentals</p>
                                            <p class="small text-purple mb-1">Today, 10:00 AM</p>
                                            <div class="d-flex gap-3 small text-muted">
                                                <span><i class="bi bi-door-open me-1"></i>Room 301</span>
                                                <span><i class="bi bi-people me-1"></i>245 students</span>
                                            </div>
                                        </div>
                                        <span class="badge bg-danger">Soon</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded border">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="fw-medium mb-1">Web Development Fundamentals</p>
                                            <p class="small text-muted mb-1">Tomorrow, 2:00 PM</p>
                                            <div class="d-flex gap-3 small text-muted">
                                                <span><i class="bi bi-door-open me-1"></i>Room 301</span>
                                                <span><i class="bi bi-people me-1"></i>245 students</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 rounded border">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="fw-medium mb-1">Advanced JavaScript</p>
                                            <p class="small text-muted mb-1">Feb 24, 9:00 AM</p>
                                            <div class="d-flex gap-3 small text-muted">
                                                <span><i class="bi bi-door-open me-1"></i>Room 405</span>
                                                <span><i class="bi bi-people me-1"></i>132 students</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 fw-bold">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex gap-3 pb-3 border-bottom">
                                    <div class="activity-dot bg-primary mt-2"></div>
                                    <div class="flex-grow-1">
                                        <p class="small fw-medium mb-1">New Submission</p>
                                        <p class="small text-muted mb-0">John Doe - React Final Project</p>
                                        <p class="small text-muted">Web Development Fundamentals</p>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="d-flex gap-3 pb-3 border-bottom">
                                    <div class="activity-dot bg-primary mt-2"></div>
                                    <div class="flex-grow-1">
                                        <p class="small fw-medium mb-1">New Submission</p>
                                        <p class="small text-muted mb-0">Jane Smith - JavaScript Quiz 2</p>
                                        <p class="small text-muted">Web Development Fundamentals</p>
                                    </div>
                                    <small class="text-muted">4 hours ago</small>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="activity-dot bg-success mt-2"></div>
                                    <div class="flex-grow-1">
                                        <p class="small fw-medium mb-1">Student Question</p>
                                        <p class="small text-muted mb-0">Robert Johnson - Array Methods</p>
                                        <p class="small text-muted">Advanced JavaScript</p>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Overview -->
            <div class="card mt-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">My Courses</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded border" style="background: #dbeafe;">
                                <p class="fw-medium mb-1">Web Development Fundamentals</p>
                                <p class="small text-primary mb-2">245 students enrolled</p>
                                <span class="badge bg-warning">12 to grade</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded border" style="background: #dcfce7;">
                                <p class="fw-medium mb-1">Advanced JavaScript</p>
                                <p class="small text-success mb-2">132 students enrolled</p>
                                <span class="badge bg-success">All caught up</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded border" style="background: #f3e8ff;">
                                <p class="fw-medium mb-1">React Advanced Topics</p>
                                <p class="small text-purple mb-2">89 students enrolled</p>
                                <span class="badge bg-warning">5 to grade</span>
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
