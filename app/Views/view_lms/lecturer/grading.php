<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading - LMS</title>
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
        .submission-card {
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .submission-card:hover {
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
                    <a href="dashboard.html" class="nav-link">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                    <a href="courses.html" class="nav-link">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                    <a href="materials.html" class="nav-link">
                        <i class="bi bi-folder me-2"></i>Materials
                    </a>
                    <a href="assignments.html" class="nav-link">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="grading.html" class="nav-link active">
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
                <h2 class="fw-bold">Grading</h2>
                <p class="text-muted">Review and grade student submissions</p>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Pending Grading</p>
                            <h4 class="fw-bold mb-0 text-warning">3</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Graded</p>
                            <h4 class="fw-bold mb-0 text-success">2</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Submissions</p>
                            <h4 class="fw-bold mb-0">5</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Average Grade</p>
                            <h4 class="fw-bold mb-0">85%</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search student or assignment..." id="searchInput" onkeyup="filterSubmissions()">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="courseFilter" onchange="filterSubmissions()">
                        <option value="all">All Courses</option>
                        <option value="Web Development Fundamentals">Web Development Fundamentals</option>
                        <option value="Advanced JavaScript">Advanced JavaScript</option>
                    </select>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-4" id="gradingTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pending" type="button">
                        <i class="bi bi-hourglass-split me-1"></i>Pending (3)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#graded" type="button">
                        <i class="bi bi-check-circle me-1"></i>Graded (2)
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Pending Submissions -->
                <div class="tab-pane fade show active" id="pending">
                    <div class="row g-3" id="pendingSubmissions">
                        <!-- Submission 1 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card submission-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">John Doe</h6>
                                            <p class="small text-muted mb-0">john.doe@email.com</p>
                                        </div>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <div class="small mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Assignment:</span>
                                            <span class="fw-medium">React Final Project</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Course:</span>
                                            <span class="fw-medium">Web Development</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Submitted:</span>
                                            <span class="fw-medium">2026-02-19</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Max Points:</span>
                                            <span class="fw-medium">100</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#gradeModal" onclick="openGrading('1')">
                                            Grade Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submission 2 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card submission-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">Jane Smith</h6>
                                            <p class="small text-muted mb-0">jane.smith@email.com</p>
                                        </div>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <div class="small mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Assignment:</span>
                                            <span class="fw-medium">React Final Project</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Course:</span>
                                            <span class="fw-medium">Web Development</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Submitted:</span>
                                            <span class="fw-medium">2026-02-20</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Max Points:</span>
                                            <span class="fw-medium">100</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#gradeModal" onclick="openGrading('2')">
                                            Grade Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submission 3 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card submission-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">Michael Wilson</h6>
                                            <p class="small text-muted mb-0">michael.w@email.com</p>
                                        </div>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <div class="small mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Assignment:</span>
                                            <span class="fw-medium">Async Programming</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Course:</span>
                                            <span class="fw-medium">Advanced JavaScript</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Submitted:</span>
                                            <span class="fw-medium">2026-02-21</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Max Points:</span>
                                            <span class="fw-medium">50</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#gradeModal" onclick="openGrading('3')">
                                            Grade Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graded Submissions -->
                <div class="tab-pane fade" id="graded">
                    <div class="row g-3">
                        <!-- Graded 1 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card submission-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">Robert Johnson</h6>
                                            <p class="small text-muted mb-0">robert.j@email.com</p>
                                        </div>
                                        <span class="badge bg-success">Graded</span>
                                    </div>
                                    <div class="text-end mb-3">
                                        <div class="d-flex align-items-center justify-content-end gap-1">
                                            <i class="bi bi-award text-purple"></i>
                                            <span class="h4 mb-0 text-purple">28/30</span>
                                        </div>
                                        <small class="text-muted">93%</small>
                                    </div>
                                    <div class="small mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Assignment:</span>
                                            <span class="fw-medium">JavaScript Quiz 2</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Course:</span>
                                            <span class="fw-medium">Web Development</span>
                                        </div>
                                    </div>
                                    <div class="p-2 bg-light rounded small mb-3">
                                        <p class="fw-medium mb-1">Feedback:</p>
                                        <p class="text-muted mb-0">Great work! Just a minor issue with async/await syntax.</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#gradeModal" onclick="openGrading('4')">
                                            Edit Grade
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Graded 2 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card submission-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">Emily Davis</h6>
                                            <p class="small text-muted mb-0">emily.davis@email.com</p>
                                        </div>
                                        <span class="badge bg-success">Graded</span>
                                    </div>
                                    <div class="text-end mb-3">
                                        <div class="d-flex align-items-center justify-content-end gap-1">
                                            <i class="bi bi-award text-purple"></i>
                                            <span class="h4 mb-0 text-purple">35/40</span>
                                        </div>
                                        <small class="text-muted">88%</small>
                                    </div>
                                    <div class="small mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Assignment:</span>
                                            <span class="fw-medium">HTML/CSS Portfolio</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Course:</span>
                                            <span class="fw-medium">Web Development</span>
                                        </div>
                                    </div>
                                    <div class="p-2 bg-light rounded small mb-3">
                                        <p class="fw-medium mb-1">Feedback:</p>
                                        <p class="text-muted mb-0">Well done! The design is clean and responsive. Minor improvements needed in accessibility.</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm flex-grow-1">
                                            <i class="bi bi-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#gradeModal" onclick="openGrading('5')">
                                            Edit Grade
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Grading Modal -->
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Grade Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 bg-light rounded mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <p class="text-muted small mb-0">Student</p>
                                <p class="fw-medium mb-0" id="gradeStudentName">John Doe</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-0">Email</p>
                                <p class="fw-medium mb-0" id="gradeStudentEmail">john.doe@email.com</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-0">Assignment</p>
                                <p class="fw-medium mb-0" id="gradeAssignment">React Final Project</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-0">Submitted</p>
                                <p class="fw-medium mb-0" id="gradeSubmittedDate">2026-02-19</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border border-dashed rounded text-center mb-4">
                        <i class="bi bi-file-earmark-zip fs-1 text-muted d-block mb-2"></i>
                        <p class="mb-1">Student Submission</p>
                        <p class="small text-muted">Click to download and review the submission</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Grade (out of <span id="maxPoints">100</span>)</label>
                        <input type="number" class="form-control" id="gradeScore" min="0" max="100" placeholder="Enter grade">
                        <div class="form-text">Percentage: <span id="gradePercentage">0</span>%</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Feedback</label>
                        <textarea class="form-control" id="gradeFeedback" rows="6" placeholder="Provide feedback to the student..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveGrade()">
                        <i class="bi bi-save me-1"></i>Save Grade
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let submissions = [
            { id: "1", studentName: "John Doe", studentEmail: "john.doe@email.com", assignment: "React Final Project", course: "Web Development Fundamentals", submittedDate: "2026-02-19", maxPoints: 100, status: "pending" },
            { id: "2", studentName: "Jane Smith", studentEmail: "jane.smith@email.com", assignment: "React Final Project", course: "Web Development Fundamentals", submittedDate: "2026-02-20", maxPoints: 100, status: "pending" },
            { id: "3", studentName: "Michael Wilson", studentEmail: "michael.w@email.com", assignment: "Async Programming Assignment", course: "Advanced JavaScript", submittedDate: "2026-02-21", maxPoints: 50, status: "pending" },
            { id: "4", studentName: "Robert Johnson", studentEmail: "robert.j@email.com", assignment: "JavaScript Quiz 2", course: "Web Development Fundamentals", submittedDate: "2026-02-19", maxPoints: 30, grade: 28, feedback: "Great work! Just a minor issue with async/await syntax.", status: "graded" },
            { id: "5", studentName: "Emily Davis", studentEmail: "emily.davis@email.com", assignment: "HTML/CSS Portfolio", course: "Web Development Fundamentals", submittedDate: "2026-02-09", maxPoints: 40, grade: 35, feedback: "Well done! The design is clean and responsive. Minor improvements needed in accessibility.", status: "graded" }
        ];

        let currentSubmissionId = null;

        function openGrading(id) {
            currentSubmissionId = id;
            const submission = submissions.find(s => s.id === id);
            
            if (submission) {
                document.getElementById('gradeStudentName').textContent = submission.studentName;
                document.getElementById('gradeStudentEmail').textContent = submission.studentEmail;
                document.getElementById('gradeAssignment').textContent = submission.assignment;
                document.getElementById('gradeSubmittedDate').textContent = submission.submittedDate;
                document.getElementById('maxPoints').textContent = submission.maxPoints;
                document.getElementById('gradeScore').value = submission.grade || '';
                document.getElementById('gradeFeedback').value = submission.feedback || '';
                updatePercentage();
            }
        }

        document.getElementById('gradeScore').addEventListener('input', updatePercentage);

        function updatePercentage() {
            const score = parseInt(document.getElementById('gradeScore').value) || 0;
            const max = parseInt(document.getElementById('maxPoints').textContent);
            const percentage = Math.round((score / max) * 100);
            document.getElementById('gradePercentage').textContent = percentage;
        }

        function saveGrade() {
            const score = parseInt(document.getElementById('gradeScore').value);
            const feedback = document.getElementById('gradeFeedback').value;

            if (!score && score !== 0) {
                alert('Please enter a grade');
                return;
            }

            const index = submissions.findIndex(s => s.id === currentSubmissionId);
            if (index !== -1) {
                submissions[index].grade = score;
                submissions[index].feedback = feedback;
                submissions[index].status = 'graded';
            }

            alert('Grade saved successfully!');
            bootstrap.Modal.getInstance(document.getElementById('gradeModal')).hide();
            location.reload();
        }

        function filterSubmissions() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const course = document.getElementById('courseFilter').value;
            
            console.log('Filtering:', search, course);
            // In a real app, this would filter the submissions
        }
    </script>
</body>
</html>
