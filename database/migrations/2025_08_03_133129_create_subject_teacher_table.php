<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Refers to subjects.id
            // $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); // Refers to teachers.id
            $table->integer('subject_id')->unsigned()->nullable();
            $table->integer('teacher_id')->unsigned()->nullable();

            $table->boolean('is_primary')->default(false);
            
            $table->text('notes')->nullable();
            $table->integer('school_id')->unsigned()->nullable();
            $table->integer('session_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->boolean('is_finalized')->default(0)->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
    
            // $table->unique(['subject_id', 'teacher_id']);
            // $table->index(['subject_id', 'status']);
            // $table->index(['teacher_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};
