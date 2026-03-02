<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Assignments</title>
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
                    <a href="/student/assignments" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="/student/grades" class="nav-link rounded px-3 py-2">
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
                    <h1 class="h3 fw-bold text-dark">Assignments</h1>
                    <p class="text-muted">Manage and submit your course assignments</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Pending</p>
                                <h3 class="fw-bold mb-0" id="pendingCount">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Submitted</p>
                                <h3 class="fw-bold mb-0" id="submittedCount">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Graded</p>
                                <h3 class="fw-bold mb-0" id="gradedCount">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <ul class="nav nav-pills mb-4" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-pending">Pending</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-submitted">Submitted</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-graded">Graded</button>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pending">
                        <div class="row g-4" id="pendingGrid"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-submitted">
                        <div class="row g-4" id="submittedGrid"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-graded">
                        <div class="row g-4" id="gradedGrid"></div>
                    </div>
                </div>
            </div>

            <!-- Submit Modal -->
            <div class="modal fade" id="submitModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Submit Assignment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="submitAssignmentId">
                            <div class="mb-3">
                                <label class="form-label">Your Submission</label>
                                <textarea class="form-control" id="submissionText" rows="6" placeholder="Paste your work here..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="submitAssignment()">Submit Assignment</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const assignments = [
            { id: 1, title: "React Final Project", course: "Web Development Fundamentals", dueDate: "Feb 23, 2026", status: "pending", description: "Build a complete React application with routing and state management" },
            { id: 2, title: "Python Assignment 4", course: "Data Science with Python", dueDate: "Feb 25, 2026", status: "pending", description: "Data visualization using Matplotlib and Seaborn" },
            { id: 3, title: "Mobile Quiz 2", course: "Mobile App Development", dueDate: "Feb 28, 2026", status: "pending", description: "React Native components and props quiz" },
            { id: 4, title: "HTML/CSS Portfolio", course: "Web Development Fundamentals", dueDate: "Feb 15, 2026", status: "submitted", description: "Create a personal portfolio website" },
            { id: 5, title: "Data Analysis Report", course: "Data Science with Python", dueDate: "Feb 10, 2026", status: "submitted", description: "Analyze the given dataset and submit findings" },
            { id: 6, title: "JavaScript Quiz", course: "Web Development Fundamentals", dueDate: "Jan 28, 2026", status: "graded", grade: "92%", description: "JavaScript fundamentals quiz" },
            { id: 7, title: "Pandas Exercises", course: "Data Science with Python", dueDate: "Jan 20, 2026", status: "graded", grade: "88%", description: "Data manipulation with Pandas" },
        ];

        function renderAssignmentCard(a) {
            if (a.status === 'pending') {
                return `
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-warning">Pending</span>
                                    <small class="text-muted">Due: ${a.dueDate}</small>
                                </div>
                                <h5 class="card-title">${a.title}</h5>
                                <p class="text-muted small mb-2">${a.course}</p>
                                <p class="small">${a.description}</p>
                                <button class="btn btn-primary btn-sm" onclick="showSubmitModal(${a.id})">Submit</button>
                            </div>
                        </div>
                    </div>
                `;
            } else if (a.status === 'submitted') {
                return `
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-info">Submitted</span>
                                    <small class="text-muted">Due: ${a.dueDate}</small>
                                </div>
                                <h5 class="card-title">${a.title}</h5>
                                <p class="text-muted small mb-2">${a.course}</p>
                                <p class="small">${a.description}</p>
                                <button class="btn btn-outline-secondary btn-sm" disabled>Awaiting Grade</button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-success">Graded</span>
                                    <span class="badge bg-primary">${a.grade}</span>
                                </div>
                                <h5 class="card-title">${a.title}</h5>
                                <p class="text-muted small mb-2">${a.course}</p>
                                <p class="small">${a.description}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        document.getElementById('pendingGrid').innerHTML = assignments.filter(a => a.status === 'pending').map(renderAssignmentCard).join('');
        document.getElementById('submittedGrid').innerHTML = assignments.filter(a => a.status === 'submitted').map(renderAssignmentCard).join('');
        document.getElementById('gradedGrid').innerHTML = assignments.filter(a => a.status === 'graded').map(renderAssignmentCard).join('');

        document.getElementById('pendingCount').textContent = assignments.filter(a => a.status === 'pending').length;
        document.getElementById('submittedCount').textContent = assignments.filter(a => a.status === 'submitted').length;
        document.getElementById('gradedCount').textContent = assignments.filter(a => a.status === 'graded').length;

        function showSubmitModal(id) {
            document.getElementById('submitAssignmentId').value = id;
            new bootstrap.Modal(document.getElementById('submitModal')).show();
        }

        function submitAssignment() {
            const id = parseInt(document.getElementById('submitAssignmentId').value);
            const assignment = assignments.find(a => a.id === id);
            if (assignment) {
                assignment.status = 'submitted';
                bootstrap.Modal.getInstance(document.getElementById('submitModal')).hide();
                location.reload();
            }
        }
    </script>
</body>
</html>
