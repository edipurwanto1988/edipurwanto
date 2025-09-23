<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    // Create or update the user
    $user = User::query()->updateOrCreate(
        ['email' => 'edipurwanto@gmail.com'],
        [
            'name' => 'Edi Purwanto',
            'password' => Hash::make('sistem123'),
            'email_verified_at' => now(),
        ]
    );

    echo "User created successfully!\n";
    echo "Email: edipurwanto@gmail.com\n";
    echo "Password: sistem123\n";
    echo "User ID: " . $user->id . "\n";

} catch (Exception $e) {
    echo "Error creating user: " . $e->getMessage() . "\n";
}