<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExam05DetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam05_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            
            $table->integer('myclass_id')->unsigned()->nullable();
            
            $table->integer('exam_name_id')->unsigned()->nullable();
            $table->integer('exam_type_id')->unsigned()->nullable();
            $table->integer('exam_part_id')->unsigned()->nullable();
            $table->integer('exam_mode_id')->unsigned()->nullable();
            


            $table->integer('order_index')->unsigned()->nullable();
            $table->boolean('is_optional')->nullable(); 

            
            
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
        Schema::dropIfExists('exam05_details');
    }
}
