<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToExam10MarksEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam10_marks_entries', function (Blueprint $table) {
            // Add composite index for common query patterns
            $table->index(['myclass_section_id', 'exam_class_subject_id', 'exam_detail_id'], 'idx_section_subject_detail');
            $table->index(['myclass_section_id', 'studentcr_id'], 'idx_section_student');
            $table->index(['exam_class_subject_id'], 'idx_exam_class_subject');
            $table->index(['exam_detail_id'], 'idx_exam_detail');
            $table->index(['studentcr_id'], 'idx_studentcr');
            $table->index(['is_active'], 'idx_is_active');
            $table->index(['created_at'], 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam10_marks_entries', function (Blueprint $table) {
            $table->dropIndex('idx_section_subject_detail');
            $table->dropIndex('idx_section_student');
            $table->dropIndex('idx_exam_class_subject');
            $table->dropIndex('idx_exam_detail');
            $table->dropIndex('idx_studentcr');
            $table->dropIndex('idx_is_active');
            $table->dropIndex('idx_created_at');
        });
    }
}
