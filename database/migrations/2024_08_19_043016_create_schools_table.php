<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('details')->nullable();
            $table->string('vill')->nullable();
            $table->string('po')->nullable();
            $table->string('ps')->nullable();
            $table->string('pin')->nullable();
            $table->string('dist')->nullable();
            $table->string('index')->nullable();
            $table->string('hscode')->nullable();
            $table->string('disecode')->nullable();
            $table->string('estd')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_finalized')->default(false);
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
        Schema::dropIfExists('schools');
    }
}
