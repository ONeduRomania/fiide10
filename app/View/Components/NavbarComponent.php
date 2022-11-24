<?php

namespace App\View\Components;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NavbarComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $loggedInUser = Auth::user();
        if ($loggedInUser == null) {
            return view('components.navbar-component');
        }

        $schoolId = 0;
        $classId = 0;
        $studentId = 0;
        if ($loggedInUser->hasRole('teacher')) {
            $teacher = Teacher::whereUserId($loggedInUser->id)->firstOrFail();
            $schoolId = $teacher->school_id;
        } else if ($loggedInUser->hasRole('student')) {
            $student = Student::whereUserId($loggedInUser->id)->firstOrFail();
            $studentId = $student->id;
            $class = Classroom::whereId($student->class_id)->firstOrFail();
            $classId = $class->id;
            $schoolId = $class->school_id;
        }

        return view('components.navbar-component', compact('schoolId', 'classId', 'studentId'));
    }
}
