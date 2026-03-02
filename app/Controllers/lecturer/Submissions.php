<?php

namespace App\Controllers\Lecturer;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\AssignmentModel;
use App\Models\CourseModel;

class Submissions extends BaseController
{
    protected $submissionModel;
    protected $assignmentModel;
    protected $courseModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->assignmentModel = new AssignmentModel();
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $lecturerId = session()->get('user_id');
        
        $courses = $this->courseModel->getCoursesByLecturer($lecturerId);
        $submissions = [];
        
        foreach ($courses as $course) {
            $assignments = $this->assignmentModel->getAssignmentsByCourse($course['id']);
            foreach ($assignments as $assignment) {
                $assignmentSubmissions = $this->submissionModel->getSubmissionsByAssignment($assignment['id']);
                foreach ($assignmentSubmissions as &$submission) {
                    $submission['assignment_title'] = $assignment['title'];
                    $submission['course_title'] = $course['title'];
                }
                $submissions = array_merge($submissions, $assignmentSubmissions);
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'submissions' => $submissions,
            'courses' => $courses
        ]);
    }

    public function getByAssignment($assignmentId)
    {
        $submissions = $this->submissionModel->getSubmissionsByAssignment($assignmentId);
        $assignment = $this->assignmentModel->getAssignmentWithModule($assignmentId);
        
        return $this->response->setJSON([
            'success' => true,
            'submissions' => $submissions,
            'assignment' => $assignment
        ]);
    }

    public function grade($id)
    {
        $score = $this->request->getPost('score');
        $feedback = $this->request->getPost('feedback');

        $result = $this->submissionModel->gradeSubmission($id, $score, $feedback);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Submission graded successfully' : 'Failed to grade submission'
        ]);
    }

    public function update($id)
    {
        $data = [
            'file_path' => $this->request->getPost('file_path'),
            'answer_text' => $this->request->getPost('answer_text')
        ];

        $result = $this->submissionModel->updateSubmission($id, $data);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Submission updated successfully' : 'Failed to update submission'
        ]);
    }

    public function delete($id)
    {
        $result = $this->submissionModel->deleteSubmission($id);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Submission deleted successfully' : 'Failed to delete submission'
        ]);
    }
}
