<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Services\MD5AuthService;

try {
    // Create MD5 auth service instance
    $authService = new MD5AuthService();
    
    // Create or update the user with MD5 password
    $user = User::query()->updateOrCreate(
        ['email' => 'adminku@example.com'],
        [
            'name' => 'adminku',
            'password' => $authService->createMD5Hash('login'),
            'email_verified_at' => now(),
        ]
    );

    echo "User with MD5 password created successfully!\n";
    echo "Email: adminku@example.com\n";
    echo "Username: adminku\n";
    echo "Password: login\n";
    echo "Password (MD5): " . $authService->createMD5Hash('login') . "\n";
    echo "User ID: " . $user->id . "\n";

} catch (Exception $e) {
    echo "Error creating user: " . $e->getMessage() . "\n";
}