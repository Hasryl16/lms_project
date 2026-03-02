<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Auth extends ResourceController
{
    use ResponseTrait;
    
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('jwt');
    }
    
    public function login()
    {
        $email = null;
        $password = null;
        $role = null;
        
        $contentType = $this->request->getHeader('Content-Type');
        
        if ($contentType && strpos($contentType->getValue(), 'application/json') !== false) {
            $rawBody = $this->request->getBody();
            $json = json_decode($rawBody, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                $email = $json['email'] ?? null;
                $password = $json['password'] ?? null;
                $role = $json['role'] ?? null;
            }
        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');
        }
        
        if (!$email || !$password || !$role) {
            return $this->respond([
                'success' => false,
                'message' => 'Email, password, and role are required'
            ], 400);
        }
        
        $allowedRoles = ['admin', 'lecturer', 'student'];
        if (!in_array($role, $allowedRoles)) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid role'
            ], 400);
        }
        
        $user = $this->userModel->findByEmailAndRole($email, $role);
        
        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid credentials for ' . $role
            ], 401);
        }
        
        // Create session for server-side auth
        $session = session();
        $session->set('user_id', $user['id']);
        $session->set('user_name', $user['name']);
        $session->set('user_email', $user['email']);
        $session->set('user_role', $user['role']);
        
        $token = generateJWT([
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role']
        ]);
        
        $redirectUrl = $this->getRedirectUrl($role);
        
        return $this->respond([
            'success'      => true,
            'message'      => 'Login successful',
            'token'        => $token,
            'redirectUrl'  => $redirectUrl,
            'user'         => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role']
            ]
        ], 200);
    }
    
    public function logout()
    {
        // Destroy session
        $session = session();
        $session->destroy();
        
        return $this->respond([
            'success'  => true,
            'message' => 'Logout successful'
        ], 200);
    }
    
    public function me()
    {
        $userData = getCurrentUserData();
        
        if (!$userData) {
            return $this->respond([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        return $this->respond([
            'success' => true,
            'user'    => $userData->data
        ], 200);
    }
    
    public function validateToken()
    {
        $userData = getCurrentUserData();
        
        if (!$userData) {
            return $this->respond([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }
        
        return $this->respond([
            'success' => true,
            'user'    => $userData->data
        ], 200);
    }
    
    private function getRedirectUrl(string $role): string
    {
        $baseUrl = rtrim(base_url(), '/');
        
        switch ($role) {
            case 'admin':
                return $baseUrl . '/admin';
            case 'lecturer':
                return $baseUrl . '/lecturer';
            case 'student':
            default:
                return $baseUrl . '/student';
        }
    }
}
