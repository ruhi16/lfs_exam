<?php
// Create storage directories for student files
$directories = [
    'storage/app/public/student-profiles',
    'storage/app/public/student-documents'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    } else {
        echo "Directory already exists: $dir\n";
    }
}

// Check if storage link exists
if (!is_link('public/storage')) {
    echo "\nIMPORTANT: You need to create the storage link by running:\n";
    echo "php artisan storage:link\n";
} else {
    echo "\nStorage link already exists.\n";
}

echo "\nStorage setup complete!\n";
