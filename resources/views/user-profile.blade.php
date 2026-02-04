<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold mb-2">User Profile</h1>
            <p class="text-gray-600 mb-6">This is a placeholder profile page. Replace with your actual profile content.</p>

            @auth
                <div class="space-y-2 text-sm">
                    <div><span class="font-medium">Name:</span> {{ auth()->user()->name }}</div>
                    <div><span class="font-medium">Email:</span> {{ auth()->user()->email }}</div>
                    <div><span class="font-medium">Role ID:</span> {{ auth()->user()->role_id }}</div>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>


first a user enter select session (auto selected current one), then myclass, section enter roll then his details with image should open but not the date of birth,
then he has to enter date of birth and if it is matched he should be represented as student profile as with the followin details

when a user is logged in and his role_id is 1, then his profile page should represent differently as students dashboard
his permanent info from studentdb and present info from studentcr should be collected, 
his examdetails should be shown in a classic tabular form, his marks and result should be shown 
overall results of his class shold also be shown, 
the request to be a teacher section should not be shown in student profile
here should a button that should be revoked his studentship by seting up role_id and studentdb_id to 0