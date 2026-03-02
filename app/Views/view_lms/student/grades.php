<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Grades</title>
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
                    <a href="/student/dashboard" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                    <a href="/student/browse" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-search me-2"></i>Browse Courses
                    </a>
                    <a href="/student/my-courses" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="/student/assignments" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="/student/grades" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-award me-2"></i>Grades
                    </a>
                </div>
            </nav>
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <a href="/" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-dark">Grades</h1>
                    <p class="text-muted">View your academic performance</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Overall Average</p>
                                <h2 class="fw-bold mb-0" id="overallAverage">85%</h2>
                                <small class="text-success"><i class="bi bi-arrow-up me-1"></i>+3% from last month</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Enrolled Courses</p>
                                <h2 class="fw-bold mb-0" id="coursesCount">4</h2>
                                <small class="text-muted">Active this semester</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Graded Assignments</p>
                                <h2 class="fw-bold mb-0" id="gradedCount">2</h2>
                                <small class="text-muted">Completed assignments</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-bold mb-0">Course Grades</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Assignments</th>
                                        <th>Quizzes</th>
                                        <th>Final Exam</th>
                                        <th>Overall</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Web Development Fundamentals</td>
                                        <td>92%</td>
                                        <td>88%</td>
                                        <td>85%</td>
                                        <td>88%</td>
                                        <td><span class="badge bg-success">B+</span></td>
                                    </tr>
                                    <tr>
                                        <td>Data Science with Python</td>
                                        <td>88%</td>
                                        <td>90%</td>
                                        <td>84%</td>
                                        <td>87%</td>
                                        <td><span class="badge bg-success">B+</span></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile App Development</td>
                                        <td>85%</td>
                                        <td>82%</td>
                                        <td>-</td>
                                        <td>83%</td>
                                        <td><span class="badge bg-primary">B</span></td>
                                    </tr>
                                    <tr>
                                        <td>UI/UX Design Basics</td>
                                        <td>78%</td>
                                        <td>80%</td>
                                        <td>-</td>
                                        <td>79%</td>
                                        <td><span class="badge bg-warning">C+</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-bold mb-0">Grading Scale</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <div class="p-3 bg-success bg-opacity-10 rounded border border-success">
                                    <p class="fw-bold text-success mb-0">A (90-100%)</p>
                                    <small class="text-success">Excellent</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 bg-primary bg-opacity-10 rounded border border-primary">
                                    <p class="fw-bold text-primary mb-0">B (80-89%)</p>
                                    <small class="text-primary">Good</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 bg-warning bg-opacity-10 rounded border border-warning">
                                    <p class="fw-bold text-warning mb-0">C (70-79%)</p>
                                    <small class="text-warning">Satisfactory</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 bg-orange bg-opacity-10 rounded border border-orange">
                                    <p class="fw-bold text-orange mb-0">D (60-69%)</p>
                                    <small class="text-orange">Passing</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 bg-danger bg-opacity-10 rounded border border-danger">
                                    <p class="fw-bold text-danger mb-0">F (0-59%)</p>
                                    <small class="text-danger">Failing</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getData() {
            return {
                courses: [
                    { id: 1, title: "Web Development Fundamentals", enrolled: true },
                    { id: 2, title: "Data Science with Python", enrolled: true },
                    { id: 3, title: "Mobile App Development", enrolled: true },
                    { id: 4, title: "UI/UX Design Basics", enrolled: false }
                ]
            };
        }
        
        const data = getData();
        const myCourses = data.courses.filter(c => c.enrolled);
        document.getElementById('coursesCount').textContent = myCourses.length;
    </script>
</body>
</html>
