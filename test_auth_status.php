<?php

require_once 'vendor/autoload.php';

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Authentication Status Test ===\n\n";

// Check if there are any users in the database
echo "1. Checking users in database...\n";
$users = \App\Models\User::all();
echo "   Total users: " . $users->count() . "\n";

if ($users->count() > 0) {
    foreach ($users as $user) {
        echo "   User: " . $user->name . " (ID: " . $user->id . ")\n";
    }
} else {
    echo "   ❌ No users found in database\n";
    echo "   🔄 Creating default admin user...\n";
    
    try {
        $user = new \App\Models\User();
        $user->id = 'admin-' . uniqid();
        $user->name = 'Admin User';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('password'); // Default password
        $user->save();
        
        echo "   ✅ Admin user created: admin@example.com / password\n";
    } catch (\Exception $e) {
        echo "   ❌ Failed to create admin user: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Test login functionality
echo "2. Testing authentication system...\n";

try {
    // Test user creation and authentication
    $testUser = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($testUser) {
        echo "   ✅ Test user found: " . $testUser->email . "\n";
        
        // Test password verification
        if (\Illuminate\Support\Facades\Hash::check('password', $testUser->password)) {
            echo "   ✅ Password verification works\n";
        } else {
            echo "   ❌ Password verification failed\n";
        }
    } else {
        echo "   ❌ Test user not found\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Authentication test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Check session configuration
echo "3. Checking session configuration...\n";
$sessionConfig = config('session');
echo "   Session driver: " . $sessionConfig['driver'] . "\n";
echo "   Session lifetime: " . $sessionConfig['lifetime'] . " minutes\n";
echo "   Session path: " . $sessionConfig['path'] . "\n";

echo "\n=== Login Instructions ===\n";
echo "If you're not logged in, follow these steps:\n\n";
echo "1. Open browser and go to: http://127.0.0.1:8000/login\n";
echo "2. Use these credentials:\n";
echo "   Email: admin@example.com\n";
echo "   Password: password\n\n";
echo "3. After successful login, navigate to:\n";
echo "   http://127.0.0.1:8000/adminku/articles/33273a5b-419f-4f9e-b425-347eccf4a13e/edit\n\n";
echo "4. Open browser developer tools (F12) and check:\n";
echo "   - Console tab for '[CKEditor Debug]' messages\n";
echo "   - Network tab for any failed requests\n";
echo "   - Elements tab to verify the content textarea exists\n\n";

echo "Test complete!\n";