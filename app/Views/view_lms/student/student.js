// Student Portal JavaScript
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
        case 'browse':
            loadBrowseCourses();
            break;
        case 'my-courses':
            loadMyCourses();
            break;
        case 'assignments':
            loadAssignments();
            break;
        case 'grades':
            loadGrades();
            break;
    }
}

// Dashboard
function loadDashboard() {
    const enrolledCount = data.studentEnrolledCourses.length;
    const pendingCount = data.assignments.filter(a => a.status === 'pending').length;
    
    document.getElementById('enrolledCourses').textContent = enrolledCount;
    document.getElementById('pendingAssignments').textContent = pendingCount;

    // Course progress
    const progressHtml = data.grades.map(grade => `
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <small class="fw-medium">${grade.course}</small>
                <small class="text-muted">${grade.currentGrade}%</small>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" style="width: ${grade.currentGrade}%"></div>
            </div>
        </div>
    `).join('');
    document.getElementById('courseProgress').innerHTML = progressHtml;
}

// Browse Courses
function loadBrowseCourses() {
    const courses = data.courses.map(c => ({
        ...c,
        enrolled: data.studentEnrolledCourses.includes(c.id)
    }));
    renderBrowseCourses(courses);
}

function renderBrowseCourses(courses) {
    const html = courses.map(course => `
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge ${getLevelBadge(course.level)}">${course.level}</span>
                        ${course.enrolled ? '<span class="badge bg-primary">Enrolled</span>' : ''}
                    </div>
                    <h5 class="card-title fw-bold">${course.title}</h5>
                    <p class="card-text text-muted small">${course.description}</p>
                </div>
                <div class="card-body pt-0">
                    <div class="small text-muted">
                        <p class="mb-1"><i class="bi bi-person me-2"></i>${course.lecturer}</p>
                        <p class="mb-1"><i class="bi bi-clock me-2"></i>${course.duration}</p>
                        <p class="mb-0"><i class="bi bi-people me-2"></i>${course.enrolledStudents} students</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    ${course.enrolled 
                        ? `<button class="btn btn-outline-primary w-100" onclick="unenrollCourse('${course.id}')">Unenroll</button>`
                        : `<button class="btn btn-primary w-100" onclick="enrollCourse('${course.id}')">Enroll Now</button>`
                    }
                </div>
            </div>
        </div>
    `).join('');
    document.getElementById('browseCoursesGrid').innerHTML = html;
}

function filterBrowseCourses(level) {
    let courses = data.courses.map(c => ({
        ...c,
        enrolled: data.studentEnrolledCourses.includes(c.id)
    }));
    
    if (level !== 'all') {
        courses = courses.filter(c => c.level === level);
    }
    
    renderBrowseCourses(courses);
}

function getLevelBadge(level) {
    switch(level) {
        case 'Beginner': return 'bg-success';
        case 'Intermediate': return 'bg-warning';
        case 'Advanced': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function enrollCourse(courseId) {
    if (!data.studentEnrolledCourses.includes(courseId)) {
        data.studentEnrolledCourses.push(courseId);
        
        // Update enrolled students count
        const course = data.courses.find(c => c.id === courseId);
        if (course) {
            course.enrolledStudents++;
        }
        
        saveData(data);
        showToast('Successfully enrolled in the course!');
        loadBrowseCourses();
    }
}

function unenrollCourse(courseId) {
    const index = data.studentEnrolledCourses.indexOf(courseId);
    if (index > -1) {
        data.studentEnrolledCourses.splice(index, 1);
        
        // Update enrolled students count
        const course = data.courses.find(c => c.id === courseId);
        if (course && course.enrolledStudents > 0) {
            course.enrolledStudents--;
        }
        
        saveData(data);
        showToast('Successfully unenrolled from the course!');
        loadBrowseCourses();
    }
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>
    `;
    
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
    }
    container.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    setTimeout(() => toast.remove(), 5000);
}

// My Courses
function loadMyCourses() {
    const myCourses = data.courses.filter(c => data.studentEnrolledCourses.includes(c.id));
    document.getElementById('myCoursesCount').textContent = myCourses.length;
    renderMyCourses(myCourses);
}

function renderMyCourses(courses) {
    if (courses.length === 0) {
        document.getElementById('myCoursesGrid').innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="bi bi-book fs-1 text-muted"></i>
                <p class="text-muted mt-3">You haven't enrolled in any courses yet</p>
                <button class="btn btn-primary" onclick="showPage('browse')">Browse Courses</button>
            </div>
        `;
        return;
    }
    
    const grades = ['A', 'B+', 'A-'];
    const progresses = [75, 60, 30];
    const deadlines = ['React Project - Due Feb 23', 'Assignment 4 - Due Feb 25', 'Design Mockup - Due Feb 28'];
    
    const html = courses.map((course, i) => {
        const progress = progresses[i] || 50;
        const grade = grades[i] || 'B';
        const deadline = deadlines[i] || 'TBD';
        
        return `
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">Enrolled</span>
                            <span class="badge bg-outline-secondary border"><i class="bi bi-award me-1"></i>Grade: ${grade}</span>
                        </div>
                        <h5 class="card-title fw-bold">${course.title}</h5>
                        <p class="card-text text-muted small">${course.description}</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                            <i class="bi bi-person"></i>
                            <span>${course.lecturer}</span>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-medium">Course Progress</span>
                                <span class="small text-muted">${progress}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: ${progress}%"></div>
                            </div>
                            <small class="text-muted">${Math.floor(course.enrolledStudents * progress / 100)} of ${course.enrolledStudents} modules completed</small>
                        </div>
                        <div class="p-2 bg-warning bg-opacity-10 rounded border border-warning">
                            <small class="text-warning fw-medium"><i class="bi bi-clock me-1"></i>Next Deadline: ${deadline}</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">Continue Learning</button>
                        <button class="btn btn-outline-secondary">Assignments</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    document.getElementById('myCoursesGrid').innerHTML = html;
}

// Assignments
function loadAssignments() {
    const pending = data.assignments.filter(a => a.status === 'pending');
    const submitted = data.assignments.filter(a => a.status === 'submitted');
    const graded = data.assignments.filter(a => a.status === 'graded');
    
    document.getElementById('pendingCount').textContent = pending.length;
    document.getElementById('submittedCount').textContent = submitted.length;
    document.getElementById('gradedCount').textContent = graded.length;
    
    renderAssignments(pending, 'pendingAssignmentsGrid');
    renderAssignments(submitted, 'submittedAssignmentsGrid');
    renderAssignments(graded, 'gradedAssignmentsGrid');
}

function renderAssignments(assignments, elementId) {
    if (assignments.length === 0) {
        document.getElementById(elementId).innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="bi bi-file-text fs-1 text-muted"></i>
                <p class="text-muted mt-3">No assignments</p>
            </div>
        `;
        return;
    }
    
    const html = assignments.map(a => {
        const daysRemaining = getDaysRemaining(a.dueDate);
        const isOverdue = daysRemaining < 0 && a.status === 'pending';
        
        return `
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-secondary">${a.course}</span>
                            <span class="badge ${getAssignmentStatusBadge(a.status, isOverdue)}">
                                ${a.status === 'graded' ? 'Graded' : a.status === 'submitted' ? 'Submitted' : isOverdue ? 'Overdue' : 'Pending'}
                            </span>
                        </div>
                        <h5 class="card-title fw-bold">${a.title}</h5>
                        <p class="card-text text-muted small">${a.description}</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>Due: ${a.dueDate}</small>
                            <span class="fw-medium">${a.points} points</span>
                        </div>
                        
                        ${a.status === 'pending' ? `
                            <div class="p-2 rounded ${isOverdue ? 'bg-danger bg-opacity-10 text-danger' : daysRemaining <= 2 ? 'bg-warning bg-opacity-10 text-warning' : 'bg-primary bg-opacity-10 text-primary'}">
                                <small class="fw-medium">
                                    ${isOverdue ? `Overdue by ${Math.abs(daysRemaining)} days` : daysRemaining === 0 ? 'Due today!' : `${daysRemaining} days remaining`}
                                </small>
                            </div>
                        ` : ''}
                        
                        ${a.status === 'submitted' ? `
                            <div class="p-2 bg-primary bg-opacity-10 rounded">
                                <small class="text-primary">Submitted on ${a.submittedDate} - Awaiting grading</small>
                            </div>
                        ` : ''}
                        
                        ${a.status === 'graded' ? `
                            <div class="p-2 bg-success bg-opacity-10 rounded mb-2">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Submitted on ${a.submittedDate}</small>
                                    <span class="fw-bold text-success">${a.grade}/${a.points}</span>
                                </div>
                            </div>
                            ${a.feedback ? `
                                <div class="p-2 bg-light rounded border">
                                    <small class="fw-medium text-muted d-block mb-1">Instructor Feedback:</small>
                                    <small class="text-muted">${a.feedback}</small>
                                </div>
                            ` : ''}
                        ` : ''}
                    </div>
                    <div class="card-footer bg-white border-0">
                        ${a.status === 'pending' ? `
                            <button class="btn btn-primary flex-grow-1" onclick="openSubmitModal('${a.id}')">
                                <i class="bi bi-upload me-2"></i>Submit Assignment
                            </button>
                        ` : a.status === 'submitted' ? `
                            <button class="btn btn-outline-secondary w-100" disabled>
                                <i class="bi bi-check-circle me-2"></i>Submitted - Awaiting Grade
                            </button>
                        ` : `
                            <button class="btn btn-outline-secondary w-100">
                                <i class="bi bi-download me-2"></i>Download Submission
                            </button>
                        `}
                    </div>
                </div>
            </div>
        `;
    }).join('');
    document.getElementById(elementId).innerHTML = html;
}

function getDaysRemaining(dueDate) {
    const today = new Date('2026-02-21');
    const due = new Date(dueDate);
    return Math.ceil((due.getTime() - today.getTime()) / (1000 * 60 * 60 * 24));
}

function getAssignmentStatusBadge(status, isOverdue) {
    switch(status) {
        case 'graded': return 'bg-success';
        case 'submitted': return 'bg-primary';
        case 'pending': return isOverdue ? 'bg-danger' : 'bg-warning';
        default: return 'bg-secondary';
    }
}

function openSubmitModal(assignmentId) {
    document.getElementById('submitAssignmentId').value = assignmentId;
    document.getElementById('submissionText').value = '';
    const modal = new bootstrap.Modal(document.getElementById('submitModal'));
    modal.show();
}

function submitAssignment() {
    const id = document.getElementById('submitAssignmentId').value;
    const assignment = data.assignments.find(a => a.id === id);
    
    if (assignment) {
        assignment.status = 'submitted';
        assignment.submittedDate = new Date().toISOString().split('T')[0];
        saveData(data);
        
        bootstrap.Modal.getInstance(document.getElementById('submitModal')).hide();
        showToast('Assignment submitted successfully!');
        loadAssignments();
    }
}

// Grades
function loadGrades() {
    const overallAvg = Math.round(data.grades.reduce((acc, g) => acc + g.currentGrade, 0) / data.grades.length);
    const totalAssignments = data.grades.reduce((acc, g) => acc + g.assignments.length, 0);
    
    document.getElementById('overallAverage').textContent = overallAvg + '%';
    document.getElementById('gradesCoursesCount').textContent = data.grades.length;
    document.getElementById('gradedAssignmentsCount').textContent = totalAssignments;
    
    renderGrades();
}

function renderGrades() {
    const html = data.grades.map(grade => `
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">${grade.course}</h5>
                        <small class="text-muted">Current Grade: ${grade.currentGrade}%</small>
                    </div>
                    <span class="badge ${getLetterGradeColor(grade.letterGrade)} fs-6">${grade.letterGrade}</span>
                </div>
                <div class="progress mt-3" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: ${grade.currentGrade}%"></div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-award me-2"></i>Assignment Breakdown</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Assignment</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${grade.assignments.map(a => `
                                <tr>
                                    <td class="fw-medium">${a.name}</td>
                                    <td>${a.score}/${a.maxScore}</td>
                                    <td><span class="${getScoreColor(a.percentage)} fw-medium">${a.percentage}%</span></td>
                                    <td class="text-muted">${a.submittedDate}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `).join('');
    document.getElementById('gradesContent').innerHTML = html;
}

function getLetterGradeColor(grade) {
    if (grade.startsWith('A')) return 'bg-success';
    if (grade.startsWith('B')) return 'bg-primary';
    if (grade.startsWith('C')) return 'bg-warning';
    return 'bg-danger';
}

function getScoreColor(percentage) {
    if (percentage >= 90) return 'text-success';
    if (percentage >= 80) return 'text-primary';
    if (percentage >= 70) return 'text-warning';
    return 'text-danger';
}

// Initialize
loadDashboard();
