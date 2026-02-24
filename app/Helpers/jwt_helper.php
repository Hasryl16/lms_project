<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * JWT Helper Functions
 * 
 * Provides functions for generating and validating JWT tokens
 */

/**
 * Get JWT configuration
 * 
 * @return array JWT configuration
 */
function getJwtConfig(): array
{
    return [
        'key'       => getenv('JWT_KEY') ?: 'your-secret-key-change-in-production',
        'algorithm' => 'HS256',
        'expiry'    => 3600 * 24, // 24 hours in seconds
    ];
}

/**
 * Generate a JWT token
 * 
 * @param array $data Data to encode in the token
 * @return string JWT token
 */
function generateJWT(array $data): string
{
    $config = getJwtConfig();
    
    $issuedAt = time();
    $expire = $issuedAt + $config['expiry'];
    
    $payload = [
        'iat'  => $issuedAt,
        'exp'  => $expire,
        'data' => $data
    ];
    
    return JWT::encode($payload, $config['key'], $config['algorithm']);
}

/**
 * Validate and decode a JWT token
 * 
 * @param string $token JWT token to validate
 * @return object|false Decoded token data or false if invalid
 */
function validateJWT(string $token)
{
    $config = getJwtConfig();
    
    try {
        return JWT::decode($token, new Key($config['key'], $config['algorithm']));
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * Get current user data from the request
 * 
 * @return object|false User data or false if not authenticated
 */
function getCurrentUserData()
{
    $request = \Config\Services::request();
    
    // Get token from header
    $token = $request->getHeader('Authorization');
    
    if ($token) {
        // Remove "Bearer " prefix if present
        $token = str_replace('Bearer ', '', $token->getValue());
    }
    
    // If no header token, check query string
    if (!$token) {
        $token = $request->getGet('token');
    }
    
    // If no query string token, check cookie
    if (!$token) {
        $token = $request->getCookie('authToken');
    }
    
    if (!$token) {
        return false;
    }
    
    return validateJWT($token);
}

/**
 * Check if user is authenticated
 * 
 * @return bool
 */
function isAuthenticated(): bool
{
    return getCurrentUserData() !== false;
}

/**
 * Get current user role
 * 
 * @return string|null
 */
function getCurrentUserRole(): ?string
{
    $userData = getCurrentUserData();
    
    if ($userData && isset($userData->data->role)) {
        return $userData->data->role;
    }
    
    return null;
}

/**
 * Check if current user has a specific role
 * 
 * @param string $role Role to check
 * @return bool
 */
function hasRole(string $role): bool
{
    return getCurrentUserRole() === $role;
}
