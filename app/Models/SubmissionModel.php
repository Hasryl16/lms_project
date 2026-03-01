<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table            = 'submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['assignment_id', 'mahasiswa_id', 'file_path', 'answer_text', 'submitted_at', 'score', 'feedback'];
    protected $useTimestamps    = false;
    
    public function getSubmissionsByAssignment($assignmentId)
    {
        return $this->select('submissions.*, users.name as student_name, users.email as student_email')
                    ->join('users', 'users.id = submissions.mahasiswa_id')
                    ->where('assignment_id', $assignmentId)
                    ->findAll();
    }
    
    public function getSubmissionWithDetails($id)
    {
        return $this->select('submissions.*, assignments.title as assignment_title, assignments.max_score, modules.title as module_title, modules.course_id, users.name as student_name, users.email as student_email')
                    ->join('assignments', 'assignments.id = submissions.assignment_id')
                    ->join('modules', 'modules.id = assignments.module_id')
                    ->join('users', 'users.id = submissions.mahasiswa_id')
                    ->where('submissions.id', $id)
                    ->first();
    }
    
    public function getPendingGradingByCourse($courseId)
    {
        return $this->select('submissions.*, assignments.title as assignment_title, assignments.max_score, modules.title as module_title, courses.title as course_title, users.name as student_name, users.email as student_email')
                    ->join('assignments', 'assignments.id = submissions.assignment_id')
                    ->join('modules', 'modules.id = assignments.module_id')
                    ->join('courses', 'courses.id = modules.course_id')
                    ->join('users', 'users.id = submissions.mahasiswa_id')
                    ->where('modules.course_id', $courseId)
                    ->where('submissions.score IS NULL')
                    ->findAll();
    }
    
    public function createSubmission($data)
    {
        $data['submitted_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
    
    public function updateSubmission($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deleteSubmission($id)
    {
        return $this->delete($id);
    }
}
