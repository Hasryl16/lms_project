<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'email', 'password', 'role', 'created_at'];
    protected $useTimestamps    = false;
    
    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function verifyPassword($password, $hash): bool
    {
        return password_verify($password, $hash);
    }
    
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    
    public function findByEmailAndRole($email, $role)
    {
        return $this->where('email', $email)
                    ->where('role', $role)
                    ->first();
    }
}
