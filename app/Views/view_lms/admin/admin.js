// Admin Portal JavaScript
let data = getData();

// Navigation
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        showPage(page);
    });
});

function showPage(pageId) {
    // Update nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-page') === pageId) {
            link.classList.add('active');
        }
    });

    // Show/hide pages
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });
    document.getElementById('page-' + pageId).classList.add('active');

    // Load page data
    switch(pageId) {
        case 'dashboard':
            loadDashboard();
            break;
        case 'courses':
            loadCourses();
            break;
        case 'students':
            loadStudents();
            break;
        case 'lecturers':
            loadLecturers();
            break;
    }
}

// Dashboard
function loadDashboard() {
    document.getElementById('totalCourses').textContent = data.courses.length;
    document.getElementById('totalStudents').textContent = data.students.length;
    document.getElementById('activeLecturers').textContent = data.lecturers.filter(l => l.status === 'Active').length;

    // Load popular courses
    const coursesHtml = data.courses.slice(0, 3).map((course, i) => `
        <div class="d-flex align-items-center justify-content-between pb-3 ${i < 2 ? 'border-bottom' : ''}">
            <div>
                <p class="fw-medium mb-0">${course.title}</p>
                <small class="text-muted">${course.enrolledStudents} students</small>
            </div>
            <div style="width: 100px;">
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: ${(course.enrolledStudents / 250) * 100}%"></div>
                </div>
            </div>
        </div>
    `).join('');
    document.getElementById('popularCourses').innerHTML = coursesHtml;
}

// Courses
function loadCourses() {
    renderCoursesTable(data.courses);
}

function renderCoursesTable(courses) {
    if (courses.length === 0) {
        document.getElementById('coursesTableBody').innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No courses found</td></tr>';
        return;
    }
    const html = courses.map(course => `
        <tr>
            <td>
                <div class="fw-medium">${course.title}</div>
                <small class="text-muted">${course.description}</small>
            </td>
            <td>${course.lecturer}</td>
            <td>${course.duration}</td>
            <td><span class="badge ${getLevelBadge(course.level)}">${course.level}</span></td>
            <td>${course.enrolledStudents}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editCourse('${course.id}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteCourse('${course.id}')"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `).join('');
    document.getElementById('coursesTableBody').innerHTML = html;
}

function getLevelBadge(level) {
    switch(level) {
        case 'Beginner': return 'bg-success';
        case 'Intermediate': return 'bg-warning';
        case 'Advanced': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function filterCourses() {
    const query = document.getElementById('courseSearch').value.toLowerCase();
    const filtered = data.courses.filter(c => 
        c.title.toLowerCase().includes(query) || 
        c.lecturer.toLowerCase().includes(query)
    );
    renderCoursesTable(filtered);
}

function showCourseModal(courseId = null) {
    const modal = new bootstrap.Modal(document.getElementById('courseModal'));
    if (courseId) {
        const course = data.courses.find(c => c.id === courseId);
        if (course) {
            document.getElementById('courseModalTitle').textContent = 'Edit Course';
            document.getElementById('courseId').value = course.id;
            document.getElementById('courseTitle').value = course.title;
            document.getElementById('courseDescription').value = course.description;
            document.getElementById('courseLecturer').value = course.lecturer;
            document.getElementById('courseDuration').value = course.duration;
            document.getElementById('courseLevel').value = course.level;
        }
    } else {
        document.getElementById('courseModalTitle').textContent = 'Create New Course';
        document.getElementById('courseForm').reset();
        document.getElementById('courseId').value = '';
    }
    modal.show();
}

function saveCourse() {
    const id = document.getElementById('courseId').value;
    const courseData = {
        id: id || Date.now().toString(),
        title: document.getElementById('courseTitle').value,
        description: document.getElementById('courseDescription').value,
        lecturer: document.getElementById('courseLecturer').value,
        duration: document.getElementById('courseDuration').value,
        level: document.getElementById('courseLevel').value,
        enrolledStudents: id ? data.courses.find(c => c.id === id)?.enrolledStudents || 0 : 0
    };
    
    if (id) {
        const index = data.courses.findIndex(c => c.id === id);
        if (index > -1) data.courses[index] = courseData;
    } else {
        data.courses.push(courseData);
    }
    
    saveData(data);
    bootstrap.Modal.getInstance(document.getElementById('courseModal')).hide();
    loadCourses();
}

function editCourse(id) {
    showCourseModal(id);
}

function deleteCourse(id) {
    if (confirm('Are you sure you want to delete this course?')) {
        data.courses = data.courses.filter(c => c.id !== id);
        saveData(data);
        loadCourses();
    }
}

// Students
function loadStudents() {
    document.getElementById('studentsTotal').textContent = data.students.length;
    document.getElementById('studentsActive').textContent = data.students.filter(s => s.status === 'Active').length;
    document.getElementById('studentsCompleted').textContent = data.students.filter(s => s.status === 'Completed').length;
    renderStudentsTable(data.students);
}

function renderStudentsTable(students) {
    if (students.length === 0) {
        document.getElementById('studentsTableBody').innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No students found</td></tr>';
        return;
    }
    const html = students.map(student => `
        <tr>
            <td>
                <div class="fw-medium">${student.name}</div>
                <small class="text-muted">ID: ${student.id}</small>
            </td>
            <td>
                <div><small><i class="bi bi-envelope me-1 text-muted"></i>${student.email}</small></div>
                <div><small><i class="bi bi-phone me-1 text-muted"></i>${student.phone}</small></div>
            </td>
            <td>
                ${student.enrolledCourses.map(c => `<span class="badge bg-secondary me-1">${c}</span>`).join('')}
            </td>
            <td><span class="badge ${getStatusBadge(student.status)}">${student.status}</span></td>
            <td>${student.enrollmentDate}</td>
        </tr>
    `).join('');
    document.getElementById('studentsTableBody').innerHTML = html;
}

function getStatusBadge(status) {
    switch(status) {
        case 'Active': return 'bg-success';
        case 'Completed': return 'bg-primary';
        case 'Inactive': return 'bg-secondary';
        default: return 'bg-secondary';
    }
}

function filterStudents() {
    const query = document.getElementById('studentSearch').value.toLowerCase();
    const filtered = data.students.filter(s => 
        s.name.toLowerCase().includes(query) || 
        s.email.toLowerCase().includes(query)
    );
    renderStudentsTable(filtered);
}

// Lecturers
function loadLecturers() {
    document.getElementById('lecturersTotal').textContent = data.lecturers.length;
    document.getElementById('lecturersActive').textContent = data.lecturers.filter(l => l.status === 'Active').length;
    document.getElementById('lecturersAvg').textContent = (data.lecturers.reduce((acc, l) => acc + l.assignedCourses.length, 0) / data.lecturers.length).toFixed(1);
    renderLecturersTable(data.lecturers);
}

function renderLecturersTable(lecturers) {
    if (lecturers.length === 0) {
        document.getElementById('lecturersTableBody').innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No lecturers found</td></tr>';
        return;
    }
    const html = lecturers.map(lecturer => `
        <tr>
            <td>
                <div class="fw-medium">${lecturer.name}</div>
                <small class="text-muted">ID: ${lecturer.id}</small>
            </td>
            <td>
                <div><small><i class="bi bi-envelope me-1 text-muted"></i>${lecturer.email}</small></div>
                <div><small><i class="bi bi-phone me-1 text-muted"></i>${lecturer.phone}</small></div>
            </td>
            <td>${lecturer.specialization}</td>
            <td>
                ${lecturer.assignedCourses.length > 0 
                    ? lecturer.assignedCourses.map(c => `<span class="badge bg-secondary me-1">${c}</span>`).join('') 
                    : '<small class="text-muted">No courses assigned</small>'}
            </td>
            <td><span class="badge ${lecturer.status === 'Active' ? 'bg-success' : 'bg-secondary'}">${lecturer.status}</span></td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editLecturer('${lecturer.id}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteLecturer('${lecturer.id}')"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `).join('');
    document.getElementById('lecturersTableBody').innerHTML = html;
}

function filterLecturers() {
    const query = document.getElementById('lecturerSearch').value.toLowerCase();
    const filtered = data.lecturers.filter(l => 
        l.name.toLowerCase().includes(query) || 
        l.specialization.toLowerCase().includes(query)
    );
    renderLecturersTable(filtered);
}

function showLecturerModal(lecturerId = null) {
    const modal = new bootstrap.Modal(document.getElementById('lecturerModal'));
    if (lecturerId) {
        const lecturer = data.lecturers.find(l => l.id === lecturerId);
        if (lecturer) {
            document.getElementById('lecturerModalTitle').textContent = 'Edit Lecturer';
            document.getElementById('lecturerId').value = lecturer.id;
            document.getElementById('lecturerName').value = lecturer.name;
            document.getElementById('lecturerEmail').value = lecturer.email;
            document.getElementById('lecturerPhone').value = lecturer.phone;
            document.getElementById('lecturerSpecialization').value = lecturer.specialization;
        }
    } else {
        document.getElementById('lecturerModalTitle').textContent = 'Create New Lecturer';
        document.getElementById('lecturerForm').reset();
        document.getElementById('lecturerId').value = '';
    }
    modal.show();
}

function saveLecturer() {
    const id = document.getElementById('lecturerId').value;
    const lecturerData = {
        id: id || Date.now().toString(),
        name: document.getElementById('lecturerName').value,
        email: document.getElementById('lecturerEmail').value,
        phone: document.getElementById('lecturerPhone').value,
        specialization: document.getElementById('lecturerSpecialization').value,
        assignedCourses: id ? data.lecturers.find(l => l.id === id)?.assignedCourses || [] : [],
        status: 'Active'
    };
    
    if (id) {
        const index = data.lecturers.findIndex(l => l.id === id);
        if (index > -1) data.lecturers[index] = lecturerData;
    } else {
        data.lecturers.push(lecturerData);
    }
    
    saveData(data);
    bootstrap.Modal.getInstance(document.getElementById('lecturerModal')).hide();
    loadLecturers();
}

function editLecturer(id) {
    showLecturerModal(id);
}

function deleteLecturer(id) {
    if (confirm('Are you sure you want to delete this lecturer?')) {
        data.lecturers = data.lecturers.filter(l => l.id !== id);
        saveData(data);
        loadLecturers();
    }
}

// Initialize
loadDashboard();
