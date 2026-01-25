<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams</title>
</head>
<body>
    @foreach ($exams as $exam)
    {{ $exam }} <br/>
    
    {{ $exam->examdetails }} <br/>
        
    @endforeach
</body>
</html>
