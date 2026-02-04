<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam08Grade extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function examType()
    {
        return $this->belongsTo(Exam02Type::class, 'exam_type_id', 'id');
    }

    public static function calculateGrade($marks, $exam_type, $subject = null, $fullMarks = null)
    {
        $type = Exam02Type::whereRaw('LOWER(name) = ?', [strtolower($exam_type)])->first();
        if (!$type) {
            return '';
        }
        $percent = null;
        if (!is_null($marks)) {
            $rounded = round($marks);
            if ($rounded < 0) {
                return 'AB';
            }
            if ($fullMarks && $fullMarks > 0) {
                $percent = round(($rounded / $fullMarks) * 100, 2);
            } else {
                $percent = $rounded;
            }
        }
        if (is_null($percent)) {
            return '';
        }
        $rows = self::where('exam_type_id', $type->id)->get();
        foreach ($rows as $row) {
            $min = $row->min_mark_percentage ?? 0;
            $max = $row->max_mark_percentage ?? 100;
            if ($percent >= $min && $percent <= $max) {
                return $row->name ?? '';
            }
        }
        return '';
    }
}
