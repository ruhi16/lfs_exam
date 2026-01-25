<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentcrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('studentdb_id');
            $table->integer('session_id');
            $table->integer('myclass_id');
            $table->integer('section_id');
            $table->integer('roll_no');            
            $table->string('result')->nullable();
            $table->string('description')->nullable();
            $table->string('crstatus')->nullable();
            $table->integer('next_class_id')->nullable();
            $table->integer('next_section_id')->nullable();  
            $table->integer('next_session_id')->nullable();
            $table->integer('next_studentcr_id')->nullable();            
            $table->integer('school_id')->nullable();
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
        Schema::dropIfExists('studentcrs');
    }
}
