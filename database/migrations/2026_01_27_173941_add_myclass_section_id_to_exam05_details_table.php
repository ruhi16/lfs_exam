<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMyclassSectionIdToExam05DetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam05_details', function (Blueprint $table) {
            if (!Schema::hasColumn('exam05_details', 'myclass_section_id')) {
                $table->integer('myclass_section_id')->unsigned()->nullable();
                // Add the foreign key constraint here
                $table->foreign('myclass_section_id')->references('id')->on('myclass_sections')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam05_details', function (Blueprint $table) {
            if (Schema::hasColumn('exam05_details', 'myclass_section_id')) {
                $table->dropForeign(['myclass_section_id']);
                $table->dropColumn('myclass_section_id');
            }
        });
    }
}
