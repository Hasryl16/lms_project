<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Manage Courses</title>
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
                <h1 class="h4 fw-bold text-dark">LMS Admin</h1>
                <p class="small text-muted mb-0">Management Portal</p>
            </div>
            <nav class="p-3">
                <div class="nav flex-column">
                    <a href="<?= base_url('/admin') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('/admin/courses') ?>" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-book me-2"></i>Courses
                    </a>
                    <a href="<?= base_url('/admin/students') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-people me-2"></i>Students
                    </a>
                    <a href="<?= base_url('/admin/lecturers') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-person-badge me-2"></i>Lecturers
                    </a>
                </div>
            </nav>
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <button onclick="logout()" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </button>
            </div>
        </aside>

        <main class="flex-grow-1" style="margin-left: 260px; min-height: 100vh;">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 fw-bold text-dark">Courses</h1>
                        <p class="text-muted">Manage your course catalog</p>
                    </div>
                    <button class="btn btn-primary" onclick="showCourseModal()">
                        <i class="bi bi-plus-lg me-2"></i>Add Course
                    </button>
                </div>
                <div class="mb-4">
                    <div class="position-relative" style="max-width: 400px;">
                        <i class="bi bi-search position-absolute start-0 top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Search courses..." id="courseSearch" onkeyup="filterCourses()">
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Course Title</th>
                                    <th>Description</th>
                                    <th>Lecturer</th>
                                    <th>Course Code</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="coursesTableBody">
                                <tr><td colspan="7" class="text-center text-muted py-4">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Course Modal -->
            <div class="modal fade" id="courseModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="courseModalTitle">Create New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="courseForm">
                                <input type="hidden" id="courseId">
                                <div class="mb-3">
                                    <label class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="courseTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="courseDescription" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Course Code</label>
                                    <input type="text" class="form-control" id="courseCode" placeholder="e.g., CS101" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lecturer</label>
                                    <select class="form-select" id="courseLecturer" required>
                                        <option value="">Select a lecturer</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveCourse()">Save Course</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get token from URL or localStorage
        const urlParams = new URLSearchParams(window.location.search);
        let token = urlParams.get('token');

        if (!token) {
            token = localStorage.getItem('authToken');
        }

        if (!token) {
            window.location.href = '<?= base_url('/login') ?>';
        }

        localStorage.setItem('authToken', token);

        // Use rtrim to remove trailing slash
        const API_BASE = '<?= rtrim(base_url(), '/') ?>';
        let allCourses = [];

        function getHeaders() {
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            };
        }

        function logout() {
            localStorage.removeItem('authToken');
            window.location.href = '<?= base_url('/login') ?>';
        }

        // Load lecturers for dropdown
        async function loadLecturers() {
            try {
                const response = await fetch(API_BASE + '/admin/api/lecturers', {
                    headers: getHeaders()
                });
                const result = await response.json();

                if (result.success) {
                    const select = document.getElementById('courseLecturer');
                    result.data.forEach(lecturer => {
                        const option = document.createElement('option');
                        option.value = lecturer.id;
                        option.textContent = lecturer.name + ' (' + lecturer.email + ')';
                        select.appendChild(option);
                    });
                }
            } catch (e) {
                console.error('Error loading lecturers:', e);
            }
        }

        // Load courses
        async function loadCourses() {
            try {
                const response = await fetch(API_BASE + '/admin/api/courses', {
                    headers: getHeaders()
                });
                const result = await response.json();

                if (result.success) {
                    allCourses = result.data;
                    renderCoursesTable(allCourses);
                } else {
                    document.getElementById('coursesTableBody').innerHTML =
                        '<tr><td colspan="7" class="text-center text-danger py-4">Error loading courses</td></tr>';
                }
            } catch (e) {
                console.error('Error:', e);
                document.getElementById('coursesTableBody').innerHTML =
                    '<tr><td colspan="7" class="text-center text-danger py-4">Error connecting to server</td></tr>';
            }
        }

        function renderCoursesTable(courses) {
            if (courses.length === 0) {
                document.getElementById('coursesTableBody').innerHTML =
                    '<tr><td colspan="7" class="text-center text-muted py-4">No courses found</td></tr>';
                return;
            }

            const html = courses.map(course => `
                <tr>
                    <td>${course.id}</td>
                    <td>
                        <div class="fw-medium">${course.title}</div>
                    </td>
                    <td><small class="text-muted">${course.description || '-'}</small></td>
                    <td>${course.lecturer_name || 'Not assigned'}</td>
                    <td><code class="text-primary">${course.course_code || 'N/A'}</code></td>
                    <td><small class="text-muted">${course.created_at || '-'}</small></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="editCourse(${course.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteCourse(${course.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
            document.getElementById('coursesTableBody').innerHTML = html;
        }

        function filterCourses() {
            const query = document.getElementById('courseSearch').value.toLowerCase();
            const filtered = allCourses.filter(c =>
                c.title.toLowerCase().includes(query) ||
                (c.description && c.description.toLowerCase().includes(query)) ||
                (c.lecturer_name && c.lecturer_name.toLowerCase().includes(query)) ||
                (c.course_code && c.course_code.toLowerCase().includes(query))
            );
            renderCoursesTable(filtered);
        }

        function showCourseModal(courseId = null) {
            const modal = new bootstrap.Modal(document.getElementById('courseModal'));

            if (courseId !== null && courseId !== undefined && courseId !== '') {
                // Convert to number for comparison
                const numericId = parseInt(courseId);
                const course = allCourses.find(c => parseInt(c.id) === numericId);
                if (course) {
                    document.getElementById('courseModalTitle').textContent = 'Edit Course';
                    document.getElementById('courseId').value = course.id;
                    document.getElementById('courseTitle').value = course.title;
                    document.getElementById('courseDescription').value = course.description || '';
                    document.getElementById('courseCode').value = course.course_code || '';
                    document.getElementById('courseLecturer').value = course.dosen_id || '';
                }
            } else {
                document.getElementById('courseModalTitle').textContent = 'Create New Course';
                document.getElementById('courseForm').reset();
                document.getElementById('courseId').value = '';
            }
            modal.show();
        }

        async function saveCourse() {
            const id = document.getElementById('courseId').value;
            const courseData = {
                title: document.getElementById('courseTitle').value,
                description: document.getElementById('courseDescription').value,
                course_code: document.getElementById('courseCode').value,
                dosen_id: document.getElementById('courseLecturer').value
            };

            if (!courseData.title) {
                alert('Please enter a course title');
                return;
            }

            if (!courseData.course_code) {
                alert('Please enter a course code');
                return;
            }

            if (!courseData.dosen_id) {
                alert('Please select a lecturer');
                return;
            }

            let url;
            if (id && id !== '') {
                url = API_BASE + '/admin/api/courses/update/' + id;
            } else {
                url = API_BASE + '/admin/api/courses/create';
            }

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify(courseData)
                });

                const result = await response.json();

                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('courseModal')).hide();
                    loadCourses();
                    alert(result.message);
                } else {
                    alert(result.message || 'Error saving course');
                }
            } catch (e) {
                console.error('Error:', e);
                alert('Error connecting to server');
            }
        }

        function editCourse(id) {
            showCourseModal(id);
        }

        async function deleteCourse(id) {
            if (!confirm('Are you sure you want to delete this course?')) {
                return;
            }

            try {
                const response = await fetch(API_BASE + '/admin/api/courses/delete/' + id, {
                    method: 'POST',
                    headers: getHeaders()
                });

                const result = await response.json();

                if (result.success) {
                    loadCourses();
                    alert(result.message);
                } else {
                    alert(result.message || 'Error deleting course');
                }
            } catch (e) {
                console.error('Error:', e);
                alert('Error connecting to server');
            }
        }

        // Initialize
        loadLecturers();
        loadCourses();
    </script>
</body>
</html>
