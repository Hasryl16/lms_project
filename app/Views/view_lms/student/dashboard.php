<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Student Dashboard</title>
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
                    <a href="dashboard.html" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                    <a href="browse.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-search me-2"></i>Browse Courses
                    </a>
                    <a href="my-courses.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="assignments.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="grades.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-award me-2"></i>Grades
                    </a>
                </div>
            </nav>
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <a href="../login.html" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-dark">Welcome back, Student!</h1>
                    <p class="text-muted">Here's your learning overview</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Enrolled Courses</p>
                                        <h3 class="fw-bold mb-0" id="enrolledCourses">0</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded p-3">
                                        <i class="bi bi-book fs-4 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Pending Assignments</p>
                                        <h3 class="fw-bold mb-0" id="pendingAssignments">0</h3>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <i class="bi bi-file-text fs-4 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Average Grade</p>
                                        <h3 class="fw-bold mb-0">85%</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <i class="bi bi-award fs-4 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-0">Study Hours</p>
                                        <h3 class="fw-bold mb-0">24</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <i class="bi bi-clock fs-4 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-start gap-3 pb-3 border-bottom">
                                    <div class="bg-warning rounded-circle mt-1" style="width: 10px; height: 10px;"></div>
                                    <div class="flex-grow-1">
                                        <p class="fw-medium mb-0">Submit React Project</p>
                                        <small class="text-muted">Web Development Fundamentals</small>
                                        <p class="small text-warning mb-0">Due in 2 days</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 py-3 border-bottom">
                                    <div class="bg-success rounded-circle mt-1" style="width: 10px; height: 10px;"></div>
                                    <div class="flex-grow-1">
                                        <p class="fw-medium mb-0">Quiz 3 Graded</p>
                                        <small class="text-muted">Data Science with Python</small>
                                        <p class="small text-success mb-0">Grade: 92%</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 pt-3">
                                    <div class="bg-primary rounded-circle mt-1" style="width: 10px; height: 10px;"></div>
                                    <div class="flex-grow-1">
                                        <p class="fw-medium mb-0">New Module Released</p>
                                        <small class="text-muted">Mobile App Development</small>
                                        <p class="small text-muted mb-0">Module 5: State Management</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">Course Progress</h5>
                            </div>
                            <div class="card-body" id="courseProgress"></div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-bold mb-0">Upcoming Deadlines</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-danger bg-opacity-10 rounded border border-danger">
                                    <p class="fw-medium text-danger mb-1">React Final Project</p>
                                    <small class="text-danger">Due: Feb 23, 2026</small>
                                    <p class="small text-danger mb-0">2 days remaining</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-warning bg-opacity-10 rounded border border-warning">
                                    <p class="fw-medium text-warning mb-1">Python Assignment 4</p>
                                    <small class="text-warning">Due: Feb 25, 2026</small>
                                    <p class="small text-warning mb-0">4 days remaining</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-primary bg-opacity-10 rounded border border-primary">
                                    <p class="fw-medium text-primary mb-1">Mobile Quiz 2</p>
                                    <small class="text-primary">Due: Feb 28, 2026</small>
                                    <p class="small text-primary mb-0">7 days remaining</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../data.js"></script>
    <script>
        const data = getData();
        const myCourses = data.courses.filter(c => c.enrolled);
        
        document.getElementById('enrolledCourses').textContent = myCourses.length;
        document.getElementById('pendingAssignments').textContent = '7';
        
        // Course progress
        const progressData = [
            { name: "Web Development Fundamentals", progress: 75 },
            { name: "Data Science with Python", progress: 60 },
            { name: "Mobile App Development", progress: 45 },
            { name: "UI/UX Design Basics", progress: 30 },
        ];
        
        document.getElementById('courseProgress').innerHTML = progressData.map(p => `
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <small class="fw-medium">${p.name}</small>
                    <small class="text-muted">${p.progress}%</small>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: ${p.progress}%"></div>
                </div>
            </div>
        `).join('');
    </script>
</body>
</html>
