<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - LMS</title>
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
        .assignment-card {
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .assignment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
                    <a href="/lecturer/dashboard" class="nav-link">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="/lecturer/courses" class="nav-link">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="/lecturer/materials" class="nav-link">
                        <i class="bi bi-folder me-2"></i>Materials
                    </a>
                    <a href="/lecturer/assignments" class="nav-link active">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Assignments</h2>
                    <p class="text-muted">Create and manage course assignments</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignmentModal" onclick="openAddModal()">
                    <i class="bi bi-plus-lg me-1"></i>Create Assignment
                </button>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Assignments</p>
                            <h4 class="fw-bold mb-0">4</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Submissions</p>
                            <h4 class="fw-bold mb-0">605</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Pending Grading</p>
                            <h4 class="fw-bold mb-0">12</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Graded</p>
                            <h4 class="fw-bold mb-0">593</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments by Course -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Web Development Fundamentals</h5>
                    <p class="text-muted small mb-0">3 assignments</p>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <!-- Assignment 1 -->
                        <div class="assignment-card p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0">React Final Project</h6>
                                        <span class="badge bg-warning">12 to grade</span>
                                    </div>
                                    <p class="small text-muted mb-0">Build a complete web application using React, including routing, state management, and API integration.</p>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Due Date</p>
                                        <p class="fw-medium mb-0">2026-02-23</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Points</p>
                                        <p class="fw-medium mb-0">100</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Submissions</p>
                                        <p class="fw-medium mb-0">235</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Graded</p>
                                        <p class="fw-medium mb-0">223</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/lecturer/grading" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-award me-1"></i>Grade Submissions (12)
                                </a>
                                <button class="btn btn-outline-secondary" onclick="editAssignment('1')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAssignment('1')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Assignment 2 -->
                        <div class="assignment-card p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0">JavaScript Quiz 2</h6>
                                        <span class="badge bg-success">All Graded</span>
                                    </div>
                                    <p class="small text-muted mb-0">Complete the quiz covering ES6 features, async/await, and modern JavaScript patterns.</p>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Due Date</p>
                                        <p class="fw-medium mb-0">2026-02-20</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Points</p>
                                        <p class="fw-medium mb-0">30</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Submissions</p>
                                        <p class="fw-medium mb-0">240</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Graded</p>
                                        <p class="fw-medium mb-0">240</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary flex-grow-1" disabled>
                                    <i class="bi bi-check-all me-1"></i>All Graded ✓
                                </button>
                                <button class="btn btn-outline-secondary" onclick="editAssignment('2')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAssignment('2')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Assignment 3 -->
                        <div class="assignment-card p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0">HTML/CSS Portfolio</h6>
                                        <span class="badge bg-success">All Graded</span>
                                    </div>
                                    <p class="small text-muted mb-0">Create a personal portfolio website using HTML and CSS.</p>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Due Date</p>
                                        <p class="fw-medium mb-0">2026-02-10</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Points</p>
                                        <p class="fw-medium mb-0">40</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Submissions</p>
                                        <p class="fw-medium mb-0">245</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Graded</p>
                                        <p class="fw-medium mb-0">245</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary flex-grow-1" disabled>
                                    <i class="bi bi-check-all me-1"></i>All Graded ✓
                                </button>
                                <button class="btn btn-outline-secondary" onclick="editAssignment('3')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAssignment('3')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Advanced JavaScript</h5>
                    <p class="text-muted small mb-0">1 assignment</p>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="assignment-card p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0">Async Programming Assignment</h6>
                                        <span class="badge bg-success">All Graded</span>
                                    </div>
                                    <p class="small text-muted mb-0">Implement various async patterns using Promises and async/await.</p>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Due Date</p>
                                        <p class="fw-medium mb-0">2026-02-28</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Points</p>
                                        <p class="fw-medium mb-0">50</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Submissions</p>
                                        <p class="fw-medium mb-0">85</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small">
                                        <p class="text-muted mb-0">Graded</p>
                                        <p class="fw-medium mb-0">85</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary flex-grow-1" disabled>
                                    <i class="bi bi-check-all me-1"></i>All Graded ✓
                                </button>
                                <button class="btn btn-outline-secondary" onclick="editAssignment('4')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAssignment('4')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Assignment Modal -->
    <div class="modal fade" id="assignmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create New Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="assignmentForm" onsubmit="saveAssignment(event)">
                    <div class="modal-body">
                        <input type="hidden" id="assignmentId">
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <select class="form-select" id="assignmentCourse" required>
                                <option value="">Select course</option>
                                <option value="Web Development Fundamentals">Web Development Fundamentals</option>
                                <option value="Advanced JavaScript">Advanced JavaScript</option>
                                <option value="React Advanced Topics">React Advanced Topics</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control" id="assignmentTitle" placeholder="e.g., React Hooks Assignment" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="assignmentDescription" rows="4" placeholder="Detailed assignment instructions..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="assignmentDueDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Points</label>
                                <input type="number" class="form-control" id="assignmentPoints" placeholder="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let assignments = [
            { id: "1", title: "React Final Project", description: "Build a complete web application using React, including routing, state management, and API integration.", course: "Web Development Fundamentals", dueDate: "2026-02-23", points: 100, totalSubmissions: 235, gradedSubmissions: 223 },
            { id: "2", title: "JavaScript Quiz 2", description: "Complete the quiz covering ES6 features, async/await, and modern JavaScript patterns.", course: "Web Development Fundamentals", dueDate: "2026-02-20", points: 30, totalSubmissions: 240, gradedSubmissions: 240 },
            { id: "3", title: "HTML/CSS Portfolio", description: "Create a personal portfolio website using HTML and CSS.", course: "Web Development Fundamentals", dueDate: "2026-02-10", points: 40, totalSubmissions: 245, gradedSubmissions: 245 },
            { id: "4", title: "Async Programming Assignment", description: "Implement various async patterns using Promises and async/await.", course: "Advanced JavaScript", dueDate: "2026-02-28", points: 50, totalSubmissions: 85, gradedSubmissions: 85 }
        ];

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Create New Assignment';
            document.getElementById('assignmentForm').reset();
            document.getElementById('assignmentId').value = '';
        }

        function editAssignment(id) {
            const assignment = assignments.find(a => a.id === id);
            if (assignment) {
                document.getElementById('modalTitle').textContent = 'Edit Assignment';
                document.getElementById('assignmentId').value = assignment.id;
                document.getElementById('assignmentCourse').value = assignment.course;
                document.getElementById('assignmentTitle').value = assignment.title;
                document.getElementById('assignmentDescription').value = assignment.description;
                document.getElementById('assignmentDueDate').value = assignment.dueDate;
                document.getElementById('assignmentPoints').value = assignment.points;
                
                const modal = new bootstrap.Modal(document.getElementById('assignmentModal'));
                modal.show();
            }
        }

        function saveAssignment(event) {
            event.preventDefault();
            
            const id = document.getElementById('assignmentId').value;
            const course = document.getElementById('assignmentCourse').value;
            const title = document.getElementById('assignmentTitle').value;
            const description = document.getElementById('assignmentDescription').value;
            const dueDate = document.getElementById('assignmentDueDate').value;
            const points = parseInt(document.getElementById('assignmentPoints').value);

            if (id) {
                const index = assignments.findIndex(a => a.id === id);
                if (index !== -1) {
                    assignments[index] = { ...assignments[index], course, title, description, dueDate, points };
                }
                alert('Assignment updated successfully!');
            } else {
                const newAssignment = {
                    id: Date.now().toString(),
                    title,
                    description,
                    course,
                    dueDate,
                    points,
                    totalSubmissions: 0,
                    gradedSubmissions: 0
                };
                assignments.push(newAssignment);
                alert('Assignment created successfully!');
            }

            bootstrap.Modal.getInstance(document.getElementById('assignmentModal')).hide();
            location.reload();
        }

        function deleteAssignment(id) {
            if (confirm('Are you sure you want to delete this assignment?')) {
                assignments = assignments.filter(a => a.id !== id);
                alert('Assignment deleted successfully!');
                location.reload();
            }
        }
    </script>
</body>
</html>
