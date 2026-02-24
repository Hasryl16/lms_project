<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Manage Lecturers</title>
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
                    <a href="<?= base_url('/admin/courses') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-book me-2"></i>Courses
                    </a>
                    <a href="<?= base_url('/admin/students') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-people me-2"></i>Students
                    </a>
                    <a href="<?= base_url('/admin/lecturers') ?>" class="nav-link rounded px-3 py-2 active">
                        <i class="bi bi-person-badge me-2"></i>Lecturers
                    </a>
                    <a href="<?= base_url('/admin/enrollments') ?>" class="nav-link rounded px-3 py-2">
                        <i class="bi bi-person-plus me-2"></i>Enrollments
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
                        <h1 class="h3 fw-bold text-dark">Lecturers</h1>
                        <p class="text-muted">Manage lecturer accounts</p>
                    </div>
                    <button class="btn btn-primary" onclick="showLecturerModal()">
                        <i class="bi bi-plus-lg me-2"></i>Add Lecturer
                    </button>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Total Lecturers</p>
                                <h3 class="fw-bold mb-0" id="lecturersTotal">-</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="position-relative" style="max-width: 400px;">
                        <i class="bi bi-search position-absolute start-0 top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Search lecturers..." id="lecturerSearch" onkeyup="filterLecturers()">
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="lecturersTableBody">
                                <tr><td colspan="5" class="text-center text-muted py-4">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Lecturer Modal -->
            <div class="modal fade" id="lecturerModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lecturerModalTitle">Create New Lecturer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="lecturerForm">
                                <input type="hidden" id="lecturerId">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="lecturerName" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="lecturerEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" id="lecturerPassword">
                                    <small class="text-muted">Leave blank to keep current password (for editing)</small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveLecturer()">Save Lecturer</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        let token = urlParams.get('token');
        
        if (!token) {
            token = localStorage.getItem('authToken');
        }
        
        if (!token) {
            window.location.href = '<?= base_url('/login') ?>';
        }
        
        localStorage.setItem('authToken', token);
        
        const API_BASE = '<?= rtrim(base_url(), '/') ?>';
        let allLecturers = [];
        
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
        
        async function loadLecturers() {
            try {
                const response = await fetch(API_BASE + '/admin/api/lecturers', {
                    headers: getHeaders()
                });
                const result = await response.json();
                
                if (result.success) {
                    allLecturers = result.data;
                    renderLecturersTable(allLecturers);
                    document.getElementById('lecturersTotal').textContent = result.data.length;
                } else {
                    document.getElementById('lecturersTableBody').innerHTML = 
                        '<tr><td colspan="5" class="text-center text-danger py-4">Error loading lecturers</td></tr>';
                }
            } catch (e) {
                console.error('Error:', e);
                document.getElementById('lecturersTableBody').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-danger py-4">Error connecting to server</td></tr>';
            }
        }
        
        function renderLecturersTable(lecturers) {
            if (lecturers.length === 0) {
                document.getElementById('lecturersTableBody').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-muted py-4">No lecturers found</td></tr>';
                return;
            }
            
            const html = lecturers.map(lecturer => `
                <tr>
                    <td>${lecturer.id}</td>
                    <td><div class="fw-medium">${lecturer.name}</div></td>
                    <td>${lecturer.email}</td>
                    <td><small class="text-muted">${lecturer.created_at || '-'}</small></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="editLecturer(${lecturer.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteLecturer(${lecturer.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
            document.getElementById('lecturersTableBody').innerHTML = html;
        }
        
        function filterLecturers() {
            const query = document.getElementById('lecturerSearch').value.toLowerCase();
            const filtered = allLecturers.filter(l => 
                l.name.toLowerCase().includes(query) || 
                l.email.toLowerCase().includes(query)
            );
            renderLecturersTable(filtered);
        }
        
        function showLecturerModal(lecturerId = null) {
            const modal = new bootstrap.Modal(document.getElementById('lecturerModal'));
            
            if (lecturerId) {
                const lecturer = allLecturers.find(l => l.id === lecturerId);
                if (lecturer) {
                    document.getElementById('lecturerModalTitle').textContent = 'Edit Lecturer';
                    document.getElementById('lecturerId').value = lecturer.id;
                    document.getElementById('lecturerName').value = lecturer.name;
                    document.getElementById('lecturerEmail').value = lecturer.email;
                    document.getElementById('lecturerPassword').value = '';
                }
            } else {
                document.getElementById('lecturerModalTitle').textContent = 'Create New Lecturer';
                document.getElementById('lecturerForm').reset();
                document.getElementById('lecturerId').value = '';
            }
            modal.show();
        }
        
        async function saveLecturer() {
            const id = document.getElementById('lecturerId').value;
            const lecturerData = {
                name: document.getElementById('lecturerName').value,
                email: document.getElementById('lecturerEmail').value,
                password: document.getElementById('lecturerPassword').value
            };
            
            if (!lecturerData.name) { alert('Please enter a name'); return; }
            if (!lecturerData.email) { alert('Please enter an email'); return; }
            if (!id && !lecturerData.password) { alert('Please enter a password'); return; }
            
            const url = id ? API_BASE + '/admin/api/lecturers/update/' + id : API_BASE + '/admin/api/lecturers/create';
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify(lecturerData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('lecturerModal')).hide();
                    loadLecturers();
                    alert(result.message);
                } else {
                    alert(result.message || 'Error saving lecturer');
                }
            } catch (e) {
                console.error('Error:', e);
                alert('Error connecting to server');
            }
        }
        
        function editLecturer(id) { showLecturerModal(id); }
        
        async function deleteLecturer(id) {
            if (!confirm('Are you sure you want to delete this lecturer?')) return;
            
            try {
                const response = await fetch(API_BASE + '/admin/api/lecturers/delete/' + id, {
                    method: 'POST',
                    headers: getHeaders()
                });
                
                const result = await response.json();
                
                if (result.success) {
                    loadLecturers();
                    alert(result.message);
                } else {
                    alert(result.message || 'Error deleting lecturer');
                }
            } catch (e) {
                console.error('Error:', e);
                alert('Error connecting to server');
            }
        }
        
        loadLecturers();
    </script>
</body>
</html>
