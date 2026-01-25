# Storage Setup for Student Database

## Issue: Uploaded pictures not showing

This happens because the storage link hasn't been created or the storage directories don't exist.

## Solution:

### Step 1: Create Storage Link

Run this command in your project root:

```bash
php artisan storage:link
```

### Step 2: Create Storage Directories (Alternative)

If you can't run artisan commands, run this PHP script:

```bash
php create-storage-dirs.php
```

### Step 3: Manual Setup (if needed)

If the above doesn't work, manually:

1. Create these directories:

    - `storage/app/public/student-profiles/`
    - `storage/app/public/student-documents/`

2. Create a symbolic link from `public/storage` to `storage/app/public`

### Step 4: Check Permissions

Make sure the storage directories have write permissions (755 or 777).

## How it works:

-   **Upload**: Files are stored in `storage/app/public/student-profiles/` and `storage/app/public/student-documents/`
-   **Display**: Files are accessed via `asset('storage/filename')` which points to `public/storage/filename`
-   **Link**: The `php artisan storage:link` creates a symbolic link from `public/storage` to `storage/app/public`

## Fixed Issues:

1. **Changed from `Storage::url()` to `asset('storage/')`**: More reliable path generation
2. **Added file existence check**: `file_exists(storage_path('app/public/' . $filename))`
3. **Added error handling**: Images that fail to load show default avatar
4. **Fallback display**: If image fails, shows default user icon

## Test:

After setup, try uploading a student profile image. It should now display correctly in both the table and modal form.
