# User Role and Privilege Management System - Enhanced

## Overview

This Livewire component provides a comprehensive Role and Privilege Management system for the Laravel LFS Exam Management application. The system allows administrators to manage user roles, assign appropriate privileges, and handle user suspension and de-assignment based on hierarchical access control.

## Enhanced Features

### 1. Role-Based Access Control

-   **Super Admin (Role ID: 5)**: Can manage any role except other Super Admins
-   **Admin (Role ID: 4)**: Can manage roles 1, 2, 3 (User, Sub Admin, Office)
-   **Office (Role ID: 3)**: Can manage roles 1, 2 (User, Sub Admin)
-   **Sub Admin (Role ID: 2)**: Can manage role 1 (User) only
-   **User (Role ID: 1)**: Cannot manage roles

### 2. Unassigned Users Management

-   **Dedicated Section**: Unassigned users (role_id = 0 or NULL) shown at bottom
-   **Visual Distinction**: Orange color coding for easy identification
-   **Filter Option**: Dedicated filter for viewing only unassigned users
-   **Priority Assignment**: Clear workflow for getting new users assigned

### 3. Resource Filtering (Following Memory Specification)

-   **Teachers**: Only unassigned teachers (user_id = NULL or 0) shown in dropdowns
-   **Students**: Verified through class, section, roll, and DOB matching
-   **Strict Compliance**: Prevents assignment conflicts and follows resource filtering rules

### 4. User Status Management

-   **Suspend Function**: Temporarily disable user access while maintaining assignments
-   **Reactivate Function**: Restore suspended users to active status
-   **Status Indicators**: Clear visual status badges (Active, Suspended, Inactive, Pending)

### 5. Complete De-assignment

-   **Reset All**: Single button to clear all user assignments
-   **Comprehensive Cleanup**: Removes role_id, teacher_id, studentdb_id
-   **Teacher Relationship Cleanup**: Automatically clears teacher.user_id when de-assigning
-   **Safety Confirmation**: Confirmation dialog to prevent accidental de-assignment

### 6. Enhanced Modal Logic

-   **Smart Button States**: Assign button enabled only when required fields are selected
-   **Role-Specific Requirements**: Different validation for different role types
-   **Real-time Feedback**: Immediate validation and error display
-   **Unassigned Resource Display**: Only shows available teachers/students

## New Methods Added

### PHP Component Methods

```php
// User management
public function suspendUser($userId)
public function reactivateUser($userId)
public function deAssignUser($userId)

// Resource filtering
public function getUnassignedTeachers()
public function canUserManageRole($roleId)

// UI helpers
public function getRoleSectionColor($roleId)
```

## Memory Compliance

### Resource Filtering Specification

-   **Teachers**: Strictly shows only unassigned teachers (user_id = NULL or 0)
-   **Students**: Verified through database matching before assignment
-   **UI Consistency**: Dropdowns only show available resources
-   **Data Integrity**: Prevents conflicts through proper filtering

This enhanced system provides comprehensive user management with proper privilege controls, resource filtering compliance, and complete lifecycle management for user assignments.

## Features

### 1. Role-Based Access Control

-   **Super Admin (Role ID: 5)**: Can assign any role to any user
-   **Admin (Role ID: 4)**: Can assign roles 1, 2, 3 (User, Sub Admin, Office)
-   **Office (Role ID: 3)**: Can assign roles 1, 2 (User, Sub Admin)
-   **Sub Admin (Role ID: 2)**: Can assign role 1 (User) only
-   **User (Role ID: 1)**: Cannot assign roles

### 2. User Management

-   View all users in a paginated table
-   Filter users by role, status, and search terms
-   See current role assignments and user details
-   View teacher and student assignments

### 3. Role Assignment Process

-   **Step 1**: Select appropriate role for the user
-   **Step 2a**: For Teacher roles (Sub Admin), assign a teacher from available teachers
-   **Step 2b**: For Student roles (User), verify student through modal with class, section, roll, and DOB

### 4. Teacher Assignment

-   Only unassigned teachers can be assigned to users
-   Teacher assignment creates bidirectional relationship:
    -   `User.teacher_id` = `Teacher.id`
    -   `Teacher.user_id` = `User.id`

### 5. Student Verification

-   Modal-based student search and verification
-   Requires: Class, Section, Roll Number, Date of Birth
-   Verification against `Studentdb` table
-   Creates assignment: `User.studentdb_id` = `Studentdb.id`

## File Structure

### Component Files

-   **Controller**: `app/Http/Livewire/UserRoleComp.php`
-   **View**: `resources/views/livewire/user-role-comp.blade.php`
-   **Test View**: `resources/views/test-user-role.blade.php`
-   **Production View**: `resources/views/user-role-management.blade.php`

### Routes

-   **Test Route**: `/test-user-role` (for development)
-   **Production Route**: `/user-role-management` (with auth middleware)

## Database Relationships

### User Model Relationships

```php
// Role relationship
public function role()
{
    return $this->belongsTo(Role::class, 'role_id', 'id');
}

// Teacher relationship
public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
}

// Student relationship
public function studentdb()
{
    return $this->belongsTo(Studentdb::class, 'studentdb_id', 'id');
}
```

### Key Database Fields

-   **Users Table**: `role_id`, `teacher_id`, `studentdb_id`, `status`
-   **Teachers Table**: `user_id`, `name`, `desig`, `mobno`
-   **Studentdb Table**: `stclass_id`, `stsection_id`, `roll`, `dob`
-   **Roles Table**: `id`, `name`, `description`

## UI Components

### Main Features

1. **Filter Section**: Search, role filter, status filter
2. **User Table**: Displays users with role, assignments, and status
3. **Role Assignment Modal**: Select role and handle teacher/student assignments
4. **Student Verification Modal**: Verify student identity before assignment

### Styling

-   Uses Tailwind CSS for responsive design
-   Font Awesome icons for visual enhancement
-   Color-coded role badges for easy identification
-   Modal overlays for focused interactions

## Security Features

### Privilege Hierarchy

-   Users can only assign roles lower than their own
-   Real-time validation of role assignment permissions
-   Comprehensive error handling and logging

### Data Validation

-   Server-side validation for all form inputs
-   Student verification prevents unauthorized assignments
-   Unique teacher-user relationships maintained

## Usage Instructions

### For Administrators

1. Navigate to User Role Management page
2. Use filters to find specific users
3. Click "Manage Role" for any user
4. Select appropriate role based on your privileges
5. Complete teacher or student assignment if required
6. Save changes

### For Teacher Assignment

1. Select "Sub Admin" role for teacher users
2. Choose from available teachers (those without user accounts)
3. Assignment creates bidirectional relationship

### For Student Assignment

1. Select "User" role for student accounts
2. Click "Search and Verify Student"
3. Enter class, section, roll number, and date of birth
4. Verify student identity before assignment

## Error Handling

-   Comprehensive try-catch blocks for all database operations
-   User-friendly error messages
-   Detailed logging for debugging
-   Graceful fallbacks for failed operations

## Performance Considerations

-   Pagination for large user lists
-   Eager loading of relationships
-   Debounced search input
-   Efficient database queries with proper indexing

## Future Enhancements

-   Bulk role assignment capabilities
-   Role permission management
-   User activity logging
-   Advanced filtering options
-   Export functionality for user reports

## Testing

-   Test route available at `/test-user-role`
-   Standalone test page with minimal dependencies
-   Production integration available at `/user-role-management`

This system provides a robust foundation for managing user roles and privileges in the Laravel LFS Exam Management application, ensuring proper access control and data integrity.
