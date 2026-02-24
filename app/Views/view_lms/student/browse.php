<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Browse Courses</title>
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
                    <a href="browse.html" class="nav-link rounded px-3 py-2 active">
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
                <a href="../index.html" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-dark">Browse Courses</h1>
                    <p class="text-muted">Discover and enroll in new courses</p>
                </div>
                <div class="mb-4">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-primary btn-sm" onclick="filterCourses('all')">All Levels</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="filterCourses('Beginner')">Beginner</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="filterCourses('Intermediate')">Intermediate</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="filterCourses('Advanced')">Advanced</button>
                    </div>
                </div>
                <div class="row g-4" id="coursesGrid"></div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../data.js"></script>
    <script>
        let data = getData();
        let currentFilter = 'all';

        function getLevelBadge(level) {
            switch(level) {
                case 'Beginner': return 'bg-success';
                case 'Intermediate': return 'bg-warning';
                case 'Advanced': return 'bg-danger';
                default: return 'bg-secondary';
            }
        }

        function renderCourses(courses) {
            if (courses.length === 0) {
                document.getElementById('coursesGrid').innerHTML = '<div class="col-12 text-center py-5"><p class="text-muted">No courses found</p></div>';
                return;
            }
            document.getElementById('coursesGrid').innerHTML = courses.map(course => `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge ${getLevelBadge(course.level)}">${course.level}</span>
                                ${course.enrolled ? '<span class="badge bg-primary">Enrolled</span>' : ''}
                            </div>
                            <h5 class="card-title">${course.title}</h5>
                            <p class="card-text text-muted small">${course.description}</p>
                            <div class="small text-muted">
                                <div><i class="bi bi-person me-2"></i>${course.lecturer}</div>
                                <div><i class="bi bi-clock me-2"></i>${course.duration}</div>
                                <div><i class="bi bi-people me-2"></i>${course.enrolledStudents} students</div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            ${course.enrolled 
                                ? '<button class="btn btn-outline-danger w-100" onclick="unenroll(\'' + course.id + '\')">Unenroll</button>'
                                : '<button class="btn btn-primary w-100" onclick="enroll(\'' + course.id + '\')">Enroll Now</button>'}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterCourses(level) {
            currentFilter = level;
            const filtered = level === 'all' ? data.courses : data.courses.filter(c => c.level === level);
            renderCourses(filtered);
        }

        function enroll(id) {
            const course = data.courses.find(c => c.id === id);
            if (course) {
                course.enrolled = true;
                course.enrolledStudents++;
                saveData(data);
                renderCourses(currentFilter === 'all' ? data.courses : data.courses.filter(c => c.level === currentFilter));
            }
        }

        function unenroll(id) {
            const course = data.courses.find(c => c.id === id);
            if (course) {
                course.enrolled = false;
                course.enrolledStudents--;
                saveData(data);
                renderCourses(currentFilter === 'all' ? data.courses : data.courses.filter(c => c.level === currentFilter));
            }
        }

        renderCourses(data.courses);
    </script>
</body>
</html>
