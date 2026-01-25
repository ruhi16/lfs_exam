<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExam06ClassSubjectsTable extends Migration
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
            $table->string('name');
            $table->string('description')->nullable();
            


            $table->integer('exam_detail_id')->unsigned()->nullable();
            $table->integer('myclass_id')->unsigned()->nullable();
            $table->integer('subject_id')->unsigned()->nullable();
            
            $table->integer('full_marks')->unsigned()->nullable();
            $table->integer('pass_marks')->unsigned()->nullable();
            $table->integer('time_in_minutes')->unsigned()->nullable();
            
            $table->boolean('is_additional')->default(0)->nullable(); 
            $table->boolean('is_combined')->default(0)->nullable(); 
            
            $table->integer('order_index')->unsigned()->nullable();
            $table->boolean('is_optional')->default(0)->nullable(); 
            
            $table->integer('exam_weightage')->unsigned()->nullable();

            
            $table->integer('session_id')->unsigned()->nullable();
            $table->integer('school_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->boolean('is_finalized')->default(0)->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
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
}
