<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Learning Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #eef2ff 100%);
            min-height: 100vh;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center p-4">
        <div class="container-fluid" style="max-width: 900px;">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">Learning Management System</h1>
                <p class="lead text-muted">Choose your portal to continue</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <a href="/student" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="card-body text-center p-5">
                                <div class="mx-auto mb-4 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-mortarboard fs-2 text-primary"></i>
                                </div>
                                <h3 class="h4 fw-bold mb-3 text-dark">Student Portal</h3>
                                <p class="text-muted mb-4">Access your courses, assignments, and grades</p>
                                <span class="btn btn-primary btn-lg">Enter Student Portal</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/lecturer" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="card-body text-center p-5">
                                <div class="mx-auto mb-4 bg-purple bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-book fs-2" style="color: #9333ea;"></i>
                                </div>
                                <h3 class="h4 fw-bold mb-3 text-dark">Lecturer Portal</h3>
                                <p class="text-muted mb-4">Manage courses, materials, and grading</p>
                                <span class="btn btn-lg" style="background: #9333ea; color: white;">Enter Lecturer Portal</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/admin" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="card-body text-center p-5">
                                <div class="mx-auto mb-4 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-shield-check fs-2" style="color: #16a34a;"></i>
                                </div>
                                <h3 class="h4 fw-bold mb-3 text-dark">Admin Portal</h3>
                                <p class="text-muted mb-4">Manage courses, students, and lecturers</p>
                                <span class="btn btn-outline-primary btn-lg">Enter Admin Portal</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
