<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Myclass;
use App\Models\SubjectType;
use App\Models\Subject;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam05Detail;
use App\Models\MyclassSubject;

class ExamSettingTestSeeder extends Seeder
{
    public function run()
    {
        // Create Classes
        $class1 = Myclass::firstOrCreate([
            'name' => 'Class 1',
            'description' => 'First Class',
            'order_index' => 1,
            'is_active' => true
        ]);

        $class2 = Myclass::firstOrCreate([
            'name' => 'Class 2',
            'description' => 'Second Class',
            'order_index' => 2,
            'is_active' => true
        ]);

        // Create Subject Types
        $writtenType = SubjectType::firstOrCreate([
            'name' => 'Written',
            'description' => 'Written subjects',
            'order_index' => 1,
            'is_active' => true
        ]);

        $practicalType = SubjectType::firstOrCreate([
            'name' => 'Practical',
            'description' => 'Practical subjects',
            'order_index' => 2,
            'is_active' => true
        ]);

        // Create Subjects
        $english = Subject::firstOrCreate([
            'name' => 'English',
            'code' => 'ENG',
            'subject_type_id' => $writtenType->id,
            'is_active' => true
        ]);

        $math = Subject::firstOrCreate([
            'name' => 'Mathematics',
            'code' => 'MATH',
            'subject_type_id' => $writtenType->id,
            'is_active' => true
        ]);

        $science = Subject::firstOrCreate([
            'name' => 'Science',
            'code' => 'SCI',
            'subject_type_id' => $practicalType->id,
            'is_active' => true
        ]);

        $music = Subject::firstOrCreate([
            'name' => 'Music',
            'code' => 'MUS',
            'subject_type_id' => $practicalType->id,
            'is_active' => true
        ]);

        // Create Exam Names
        $firstTerm = Exam01Name::firstOrCreate([
            'name' => 'First Terminal Exam',
            'description' => 'First terminal examination',
            'order_index' => 1,
            'is_active' => true
        ]);

        $midTerm = Exam01Name::firstOrCreate([
            'name' => 'Mid Term Exam',
            'description' => 'Mid terminal examination',
            'order_index' => 2,
            'is_active' => true
        ]);

        // Create Exam Types
        $written = Exam02Type::firstOrCreate([
            'name' => 'Written',
            'description' => 'Written examination',
            'order_index' => 1,
            'is_active' => true
        ]);

        $practical = Exam02Type::firstOrCreate([
            'name' => 'Practical',
            'description' => 'Practical examination',
            'order_index' => 2,
            'is_active' => true
        ]);

        // Create Class-Subject relationships
        MyclassSubject::firstOrCreate([
            'myclass_id' => $class1->id,
            'subject_id' => $english->id,
        ], [
            'name' => 'Class 1 - English',
            'description' => 'English subject for Class 1',
            'is_active' => true
        ]);

        MyclassSubject::firstOrCreate([
            'myclass_id' => $class1->id,
            'subject_id' => $math->id,
        ], [
            'name' => 'Class 1 - Mathematics',
            'description' => 'Mathematics subject for Class 1',
            'is_active' => true
        ]);

        MyclassSubject::firstOrCreate([
            'myclass_id' => $class1->id,
            'subject_id' => $science->id,
        ], [
            'name' => 'Class 1 - Science',
            'description' => 'Science subject for Class 1',
            'is_active' => true
        ]);

        MyclassSubject::firstOrCreate([
            'myclass_id' => $class1->id,
            'subject_id' => $music->id,
        ], [
            'name' => 'Class 1 - Music',
            'description' => 'Music subject for Class 1',
            'is_active' => true
        ]);

        // Create Exam Details for Class 1
        Exam05Detail::firstOrCreate([
            'name' => 'First Term Written - Class 1',
            'description' => 'First terminal written exam for class 1',
            'myclass_id' => $class1->id,
            'exam_name_id' => $firstTerm->id,
            'exam_type_id' => $written->id,
            'order_index' => 1,
            'is_active' => true
        ]);

        Exam05Detail::firstOrCreate([
            'name' => 'First Term Practical - Class 1',
            'description' => 'First terminal practical exam for class 1',
            'myclass_id' => $class1->id,
            'exam_name_id' => $firstTerm->id,
            'exam_type_id' => $practical->id,
            'order_index' => 2,
            'is_active' => true
        ]);

        Exam05Detail::firstOrCreate([
            'name' => 'Mid Term Written - Class 1',
            'description' => 'Mid terminal written exam for class 1',
            'myclass_id' => $class1->id,
            'exam_name_id' => $midTerm->id,
            'exam_type_id' => $written->id,
            'order_index' => 3,
            'is_active' => true
        ]);

        echo "Exam setting test data created successfully!\n";
    }

    // php artisan db:seed --class=ExamSettingTestSeeder
}