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
        return $this->select('submissions.*, users.name as mahasiswa_name, users.email as mahasiswa_email')
                    ->join('users', 'users.id = submissions.mahasiswa_id', 'left')
                    ->where('assignment_id', $assignmentId)
                    ->findAll();
    }

    public function getSubmissionByMahasiswa($assignmentId, $mahasiswaId)
    {
        return $this->where('assignment_id', $assignmentId)
                    ->where('mahasiswa_id', $mahasiswaId)
                    ->first();
    }

    public function getSubmissionsByMahasiswa($mahasiswaId)
    {
        return $this->select('submissions.*, assignments.title as assignment_title, modules.title as module_title, courses.title as course_title')
                    ->join('assignments', 'assignments.id = submissions.assignment_id', 'left')
                    ->join('modules', 'modules.id = assignments.module_id', 'left')
                    ->join('courses', 'courses.id = modules.course_id', 'left')
                    ->where('submissions.mahasiswa_id', $mahasiswaId)
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

    public function gradeSubmission($id, $score, $feedback)
    {
        return $this->update($id, [
            'score' => $score,
            'feedback' => $feedback
        ]);
    }
}
