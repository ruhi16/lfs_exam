<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('details')->nullable();
            $table->string('code')->nullable();
            $table->date('stdate');
            $table->date('entdate');
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->integer('prev_session_id')->nullable();
            $table->integer('next_session_id')->nullable();
            $table->integer('school_id')->nullable();
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
        Schema::dropIfExists('sessions');
    }
}
