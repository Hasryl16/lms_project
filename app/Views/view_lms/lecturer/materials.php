<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Materials - LMS</title>
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
        .material-card {
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .material-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .file-drop-zone {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .file-drop-zone:hover {
            border-color: #9333ea;
            background: #faf5ff;
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
                    <a href="materials.html" class="nav-link active">
                        <i class="bi bi-folder me-2"></i>Materials
                    </a>
                    <a href="assignments.html" class="nav-link">
                        <i class="bi bi-file-text me-2"></i>Assignments
                    </a>
                    <a href="grading.html" class="nav-link">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Course Materials</h2>
                    <p class="text-muted">Manage learning resources for your courses</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materialModal" onclick="openAddModal()">
                    <i class="bi bi-plus-lg me-1"></i>Add Material
                </button>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Total Materials</p>
                            <h4 class="fw-bold mb-0">4</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">PDFs</p>
                            <h4 class="fw-bold mb-0">1</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Videos</p>
                            <h4 class="fw-bold mb-0">1</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">Links</p>
                            <h4 class="fw-bold mb-0">1</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials by Course -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Web Development Fundamentals</h5>
                    <p class="text-muted small mb-0">2 materials</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="material-card p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-file-earmark-pdf text-danger mt-1"></i>
                                        <div>
                                            <h6 class="mb-0">Introduction to HTML</h6>
                                            <p class="small text-muted mb-0">Basic HTML structure and elements</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger">PDF</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Uploaded: 2026-02-15</span>
                                    <span>2.4 MB</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary flex-grow-1">
                                        <i class="bi bi-download me-1"></i>Download
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editMaterial('1')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMaterial('1')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="material-card p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-play-circle text-primary mt-1"></i>
                                        <div>
                                            <h6 class="mb-0">CSS Flexbox Tutorial</h6>
                                            <p class="small text-muted mb-0">Complete guide to CSS Flexbox layout</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary">Video</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Uploaded: 2026-02-18</span>
                                    <span>45.2 MB</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary flex-grow-1">
                                        <i class="bi bi-download me-1"></i>Download
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editMaterial('2')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMaterial('2')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Advanced JavaScript</h5>
                    <p class="text-muted small mb-0">1 material</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="material-card p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-file-earmark-text text-success mt-1"></i>
                                        <div>
                                            <h6 class="mb-0">JavaScript ES6 Features</h6>
                                            <p class="small text-muted mb-0">Arrow functions, destructuring, and more</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-success">Document</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Uploaded: 2026-02-10</span>
                                    <span>1.8 MB</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary flex-grow-1">
                                        <i class="bi bi-download me-1"></i>Download
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editMaterial('3')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMaterial('3')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="material-card p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-link-45deg text-purple mt-1"></i>
                                        <div>
                                            <h6 class="mb-0">MDN Web Docs</h6>
                                            <p class="small text-muted mb-0">Official Mozilla documentation</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-purple" style="background: #9333ea;">Link</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Uploaded: 2026-02-05</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="https://developer.mozilla.org" target="_blank" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Open Link
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editMaterial('4')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMaterial('4')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Material Modal -->
    <div class="modal fade" id="materialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="materialForm" onsubmit="saveMaterial(event)">
                    <div class="modal-body">
                        <input type="hidden" id="materialId">
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <select class="form-select" id="materialCourse" required>
                                <option value="">Select course</option>
                                <option value="Web Development Fundamentals">Web Development Fundamentals</option>
                                <option value="Advanced JavaScript">Advanced JavaScript</option>
                                <option value="React Advanced Topics">React Advanced Topics</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Material Title</label>
                            <input type="text" class="form-control" id="materialTitle" placeholder="e.g., Introduction to React Hooks" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="materialDescription" rows="3" placeholder="Brief description of the material" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Material Type</label>
                            <select class="form-select" id="materialType" required>
                                <option value="PDF">PDF Document</option>
                                <option value="Video">Video</option>
                                <option value="Document">Document</option>
                                <option value="Link">External Link</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload File</label>
                            <div class="file-drop-zone" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-cloud-upload fs-3 text-muted d-block mb-2"></i>
                                <p class="mb-1">Click to upload or drag and drop</p>
                                <p class="small text-muted mb-0">PDF, DOC, MP4, or any file (Max 100MB)</p>
                                <input type="file" id="fileInput" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample data
        let materials = [
            { id: "1", title: "Introduction to HTML", description: "Basic HTML structure and elements", course: "Web Development Fundamentals", type: "PDF", fileName: "html-basics.pdf", uploadDate: "2026-02-15", size: "2.4 MB" },
            { id: "2", title: "CSS Flexbox Tutorial", description: "Complete guide to CSS Flexbox layout", course: "Web Development Fundamentals", type: "Video", fileName: "flexbox-tutorial.mp4", uploadDate: "2026-02-18", size: "45.2 MB" },
            { id: "3", title: "JavaScript ES6 Features", description: "Arrow functions, destructuring, and more", course: "Advanced JavaScript", type: "Document", fileName: "es6-features.docx", uploadDate: "2026-02-10", size: "1.8 MB" },
            { id: "4", title: "MDN Web Docs", description: "Official Mozilla documentation", course: "Web Development Fundamentals", type: "Link", uploadDate: "2026-02-05" }
        ];

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Material';
            document.getElementById('materialForm').reset();
            document.getElementById('materialId').value = '';
        }

        function editMaterial(id) {
            const material = materials.find(m => m.id === id);
            if (material) {
                document.getElementById('modalTitle').textContent = 'Edit Material';
                document.getElementById('materialId').value = material.id;
                document.getElementById('materialCourse').value = material.course;
                document.getElementById('materialTitle').value = material.title;
                document.getElementById('materialDescription').value = material.description;
                document.getElementById('materialType').value = material.type;
                
                const modal = new bootstrap.Modal(document.getElementById('materialModal'));
                modal.show();
            }
        }

        function saveMaterial(event) {
            event.preventDefault();
            
            const id = document.getElementById('materialId').value;
            const course = document.getElementById('materialCourse').value;
            const title = document.getElementById('materialTitle').value;
            const description = document.getElementById('materialDescription').value;
            const type = document.getElementById('materialType').value;

            if (id) {
                // Update existing
                const index = materials.findIndex(m => m.id === id);
                if (index !== -1) {
                    materials[index] = { ...materials[index], course, title, description, type };
                }
                alert('Material updated successfully!');
            } else {
                // Add new
                const newMaterial = {
                    id: Date.now().toString(),
                    title,
                    description,
                    course,
                    type,
                    fileName: title.toLowerCase().replace(/\s+/g, '-') + '.' + type.toLowerCase(),
                    uploadDate: new Date().toISOString().split('T')[0],
                    size: '2.5 MB'
                };
                materials.push(newMaterial);
                alert('Material added successfully!');
            }

            bootstrap.Modal.getInstance(document.getElementById('materialModal')).hide();
            location.reload();
        }

        function deleteMaterial(id) {
            if (confirm('Are you sure you want to delete this material?')) {
                materials = materials.filter(m => m.id !== id);
                alert('Material deleted successfully!');
                location.reload();
            }
        }
    </script>
</body>
</html>
