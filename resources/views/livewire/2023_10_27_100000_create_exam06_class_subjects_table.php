<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam06_class_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->foreignId('exam_detail_id')->constrained('exam05_details')->onDelete('cascade');
            $table->foreignId('myclass_id')->constrained('myclasses')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

            $table->unsignedInteger('full_marks');
            $table->unsignedInteger('pass_marks');
            $table->unsignedInteger('time_in_minutes');

            $table->boolean('is_finalized')->default(false);
            $table->boolean('is_active')->default(true);

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');

            $table->timestamps();

            // Add a unique constraint to prevent duplicate entries for the same exam part and subject
            $table->unique(['exam_detail_id', 'subject_id'], 'exam_detail_subject_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam06_class_subjects');
    }
};
