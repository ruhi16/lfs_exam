<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentdbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentdbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('studentid')->nullable();
            $table->string('uuid_auto')->nullable();

            $table->unsignedinteger('admBookNo')->nullable();
            $table->unsignedinteger('admSlNo')->nullable();
            $table->date('admDate')->nullable();

            $table->string('prCls')->nullable();
            $table->string('prSch')->nullable();


            $table->string('name');
            $table->string('adhaar')->nullable();
            $table->string('fname')->nullable();
            $table->string('fadhaar')->nullable();
            $table->string('mname')->nullable();
            $table->string('madhaar')->nullable();
            $table->date('dob')->nullable();
            // 
            // $table->date('doadm')->nullable();            
            $table->string('vill1')->nullable();
            $table->string('vill2')->nullable();
            $table->string('post')->nullable();
            $table->string('pstn')->nullable();
            $table->string('dist')->nullable();
            $table->string('pin')->nullable();
            $table->string('state')->nullable();
            $table->string('mobl1')->nullable();
            $table->string('mobl2')->nullable();

            $table->string('ssex')->nullable();
            $table->string('blood_grp')->nullable();
            $table->string('phch')->nullable();
            $table->string('relg')->nullable();
            $table->string('cste')->nullable();
            $table->string('natn')->nullable();

            $table->string('accNo')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('micr')->nullable();
            $table->string('bnnm')->nullable();
            $table->string('brnm')->nullable();

            $table->integer('stclass_id')->nullable();
            $table->integer('stsection_id')->nullable();
            $table->integer('session_id')->nullable();
            $table->integer('school_id')->nullable();
            $table->integer('streason')->nullable();

            $table->integer('enclass_id')->nullable();
            $table->integer('ensection_id')->nullable();
            $table->integer('ensession_id')->nullable();
            $table->string('enreason')->nullable();

            $table->string('img_ref_profile')->nullable();
            $table->string('img_ref_brthcrt')->nullable();
            $table->string('img_ref_adhaar')->nullable();



            $table->integer('user_id');

            $table->string('crstatus')->nullable();
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
        Schema::dropIfExists('studentdbs');
    }
}
