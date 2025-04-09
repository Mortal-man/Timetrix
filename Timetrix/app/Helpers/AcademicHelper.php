<?php

namespace App\Helpers;

class AcademicHelper
{
    public static function getCurrentAcademicSession()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        if ($currentMonth >= 9 && $currentMonth <= 12) {
            // September - December (Semester 1 of Current Year + Next Year)
            return [
                'semester' => 'Semester 1',
                'academic_year' => $currentYear . '/' . ($currentYear + 1)
            ];
        } elseif ($currentMonth >= 1 && $currentMonth <= 4) {
            // January - April (Semester 2 of Previous Year + Current Year)
            return [
                'semester' => 'Semester 2',
                'academic_year' => ($currentYear - 1) . '/' . $currentYear
            ];
        } else {
            // May - August (Break Period / Trimester Systems)
            return [
                'semester' => 'Out of Semester',
                'academic_year' => ''
            ];
        }
    }
}
