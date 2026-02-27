<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id', 'name', 'email', 'password', 'role', 'created_at'];
    protected $useTimestamps    = false;
    

    public function generateUserId(string $role): string
    {
        $prefix = '';
        
        switch ($role) {
            case 'admin':
                $prefix = 'A';
                break;
            case 'lecturer':
                $prefix = 'L';
                break;
            case 'student':
            default:
                $prefix = 'S';
                break;
        }
        
        // Get the last user with this role
        $lastUser = $this->where('role', $role)
                         ->orderBy('id', 'DESC')
                         ->first();
        
        if ($lastUser) {
            // Extract the numeric part and increment
            $lastId = $lastUser['id'];
            $num = (int)substr($lastId, 1);
            $newNum = $num + 1;
        } else {
            // First user of this role
            $newNum = 1;
        }
        
        // Format: prefix + 3-digit number (e.g., S001, L001, A001)
        return $prefix . str_pad($newNum, 3, '0', STR_PAD_LEFT);
    }
    
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
