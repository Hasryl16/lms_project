<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    /**
     * Get JWT key - matches the helper function
     */
    private function getJwtKey(): string
    {
        return getenv('JWT_KEY') ?: 'your-secret-key-change-in-production';
    }
    
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return a Response.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = $request->getHeader('Authorization');
        
        // If no Authorization header, check for token in query string or cookie
        if (!$token) {
            $token = $request->getGet('token');
            if (!$token) {
                $token = $request->getCookie('authToken');
            }
        } else {
            // Remove "Bearer " prefix if present
            $token = str_replace('Bearer ', '', $token->getValue());
        }
        
        if (!$token) {
            return response()->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Authorization token required'
            ]);
        }
        
        try {
            // Get JWT key 
            $jwtKey = $this->getJwtKey();
            
            // Decode the token
            $decoded = JWT::decode($token, new Key($jwtKey, 'HS256'));
            
// Check if role is allowed
            if ($arguments && !in_array($decoded->data->role, $arguments)) {
                return response()->setStatusCode(403)->setJSON([
                    'success' => false,
                    'message' => 'Access denied. Insufficient permissions.'
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Invalid or expired token'
            ]);
        }
    }

    /**
     * Allows After filters and modify the response
     * object to inspect as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface  $response
     * @param array|null         $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
