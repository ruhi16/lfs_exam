<?php
echo "=== Student Database Storage Setup ===\n\n";

// Check current directory
echo "Current directory: " . getcwd() . "\n";

// Create storage directories
$directories = [
    'storage/app/public',
    'storage/app/public/student-profiles',
    'storage/app/public/student-documents'
];

echo "\n1. Creating storage directories...\n";
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✓ Created: $dir\n";
        } else {
            echo "✗ Failed to create: $dir\n";
        }
    } else {
        echo "✓ Already exists: $dir\n";
    }
}

// Check/create storage link
echo "\n2. Checking storage link...\n";
$linkPath = 'public/storage';
$targetPath = '../storage/app/public';

if (is_link($linkPath)) {
    echo "✓ Storage link already exists\n";
    echo "  Link: $linkPath -> " . readlink($linkPath) . "\n";
} else {
    if (is_dir('public') && is_dir('storage/app/public')) {
        if (symlink($targetPath, $linkPath)) {
            echo "✓ Created storage link: $linkPath -> $targetPath\n";
        } else {
            echo "✗ Failed to create storage link\n";
            echo "  You may need to run: php artisan storage:link\n";
        }
    } else {
        echo "✗ Required directories not found\n";
    }
}

// Test file operations
echo "\n3. Testing file operations...\n";
$testFile = 'storage/app/public/test-image.txt';
$testContent = 'This is a test file for storage setup';

if (file_put_contents($testFile, $testContent)) {
    echo "✓ Can write to storage directory\n";

    // Test access via public link
    $publicTestFile = 'public/storage/test-image.txt';
    if (file_exists($publicTestFile)) {
        echo "✓ File accessible via public storage link\n";
        unlink($testFile); // Clean up
        echo "✓ Test file cleaned up\n";
    } else {
        echo "✗ File not accessible via public storage link\n";
        echo "  Check if storage link is working properly\n";
    }
} else {
    echo "✗ Cannot write to storage directory\n";
    echo "  Check directory permissions\n";
}

// Show final status
echo "\n=== Setup Summary ===\n";
echo "Storage directories: " . (is_dir('storage/app/public/student-profiles') ? "✓" : "✗") . "\n";
echo "Storage link: " . (is_link('public/storage') ? "✓" : "✗") . "\n";
echo "Write permissions: " . (is_writable('storage/app/public') ? "✓" : "✗") . "\n";

echo "\n=== Next Steps ===\n";
echo "1. If storage link failed, run: php artisan storage:link\n";
echo "2. Test uploading a student profile image\n";
echo "3. Check the debug panel for detailed storage information\n";
echo "4. If images still don't show, check browser console for 404 errors\n";

echo "\nSetup complete!\n";
