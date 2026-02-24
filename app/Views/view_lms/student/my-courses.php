<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - My Courses</title>
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
                    <a href="dashboard.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                    <a href="browse.html" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-search me-2"></i>Browse Courses
                    </a>
                    <a href="my-courses.html" class="nav-link rounded px-3 py-2 active">
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
                <a href="../index.html" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-dark">My Courses</h1>
                    <p class="text-muted">Continue your learning journey</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Enrolled Courses</p>
                                <h3 class="fw-bold mb-0" id="myCoursesCount">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Average Progress</p>
                                <h3 class="fw-bold mb-0">55%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Average Grade</p>
                                <h3 class="fw-bold mb-0">B+</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4" id="myCoursesGrid"></div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../data.js"></script>
    <script>
        const data = getData();
        const myCourses = data.courses.filter(c => c.enrolled);
        
        const progressData = [
            { name: "Web Development Fundamentals", progress: 75 },
            { name: "Data Science with Python", progress: 60 },
            { name: "Mobile App Development", progress: 45 },
            { name: "UI/UX Design Basics", progress: 30 },
        ];
        
        document.getElementById('myCoursesCount').textContent = myCourses.length;
        
        document.getElementById('myCoursesGrid').innerHTML = myCourses.length === 0 
            ? '<div class="col-12 text-center py-5"><p class="text-muted">You have not enrolled in any courses yet.</p><a href="browse.html" class="btn btn-primary">Browse Courses</a></div>'
            : myCourses.map((course, i) => `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">${course.title}</h5>
                            <p class="card-text text-muted small">${course.description}</p>
                            <div class="small text-muted mb-3">
                                <div><i class="bi bi-person me-2"></i>${course.lecturer}</div>
                                <div><i class="bi bi-clock me-2"></i>${course.duration}</div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="fw-medium">Progress</small>
                                    <small class="text-muted">${progressData[i]?.progress || 0}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: ${progressData[i]?.progress || 0}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="assignments.html" class="btn btn-outline-primary w-100">View Assignments</a>
                        </div>
                    </div>
                </div>
            `).join('');
    </script>
</body>
</html>
