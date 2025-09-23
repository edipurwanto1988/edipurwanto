<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Services\MD5AuthService;

try {
    // Create MD5 auth service instance
    $authService = new MD5AuthService();
    
    // Test credentials
    $email = 'adminku@example.com';
    $password = 'login';
    
    echo "Testing MD5 login functionality...\n";
    echo "Email: $email\n";
    echo "Password: $password\n";
    echo "Expected MD5 hash: " . $authService->createMD5Hash($password) . "\n";
    
    // Get the user from database
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        echo "ERROR: User not found in database!\n";
        exit(1);
    }
    
    echo "User found in database:\n";
    echo "- ID: " . $user->id . "\n";
    echo "- Name: " . $user->name . "\n";
    echo "- Email: " . $user->email . "\n";
    echo "- Password (stored): " . $user->password . "\n";
    echo "- Is MD5 hash: " . (ctype_xdigit($user->password) && strlen($user->password) === 32 ? 'YES' : 'NO') . "\n";
    
    // Test authentication
    try {
        $authenticatedUser = $authService->authenticate($email, $password);
        echo "\nSUCCESS: Authentication successful!\n";
        echo "Authenticated user ID: " . $authenticatedUser->id . "\n";
        echo "Authenticated user name: " . $authenticatedUser->name . "\n";
    } catch (Exception $e) {
        echo "\nERROR: Authentication failed!\n";
        echo "Error message: " . $e->getMessage() . "\n";
    }
    
    // Test with wrong password
    echo "\n--- Testing with wrong password ---\n";
    try {
        $authService->authenticate($email, 'wrongpassword');
        echo "ERROR: Authentication should have failed with wrong password!\n";
    } catch (Exception $e) {
        echo "SUCCESS: Authentication correctly failed with wrong password\n";
        echo "Error message: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}