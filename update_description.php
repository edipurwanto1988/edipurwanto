<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Setting;

try {
    // Get the first setting record or create one if it doesn't exist
    $setting = Setting::query()->firstOrCreate([]);
    
    // Update the homepage description
    $setting->homepage_description = 'Blog personal berisi ide, catatan perjalanan, dan referensi.';
    $setting->save();
    
    echo "Homepage description has been updated successfully!\n";
    echo "New description: " . $setting->homepage_description . "\n";
    
} catch (Exception $e) {
    echo "Error updating homepage description: " . $e->getMessage() . "\n";
}