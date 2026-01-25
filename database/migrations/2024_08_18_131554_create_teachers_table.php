<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->string('nickName')->nullable();
            $table->string('mobno')->nullable();
            $table->string('desig')->nullable();
            $table->string('hqual')->nullable();
            $table->string('train_qual')->nullable();
            $table->string('extra_qual')->nullable();
            $table->string('main_subject_id')->nullable();
            
            $table->string('notes')->nullable();            
            $table->integer('prev_session_pk')->nullable();
            $table->string('img_ref')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->integer('user_id');
            $table->boolean('is_active')->default(1);
            $table->integer('session_id');
            $table->integer('school_id');
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
        Schema::dropIfExists('teachers');
    }
}
