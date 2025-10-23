<?php

// Test Cloudinary directly
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Cloudinary configuration...\n";
echo "CLOUDINARY_URL: " . env('CLOUDINARY_URL') . "\n";
echo "Config cloud_url: " . config('cloudinary.cloud_url') . "\n\n";

try {
    // Test with a simple URL upload
    $result = CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload('https://via.placeholder.com/150', [
        'folder' => 'Luxus/test-direct',
    ]);

    echo "✅ Upload successful!\n";
    echo "Result type: " . get_class($result) . "\n";
    echo "Public ID: " . $result->getPublicId() . "\n";
    echo "Secure URL: " . $result->getSecurePath() . "\n";
} catch (\Exception $e) {
    echo "❌ Upload failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
