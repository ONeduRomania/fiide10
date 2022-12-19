<div>
    <a class="nav-item nav-link"
        href="{{ route('classes.student.show', ['school' => $schoolId, 'class' => $classId, 'student' => $studentId]) }}">{{ __('Situația școlară') }}</a>

    <a class="nav-item nav-link"
        href="{{ route('homework.show_student_homework', ['school' => $schoolId, 'class' => $classId]) }}">{{ __('Sarcini de lucru') }}</a>

    <a class="nav-item nav-link"
        href="{{ route('timetable.index', ['school' => $schoolId, 'class' => $classId]) }}">{{ __('Orar') }}</a>

    <a class="nav-item nav-link" href="https://onedu.ro/voluntariaza">{{ __('Voluntariat') }}</a>

    <a href="{{ route('logout') }}" class="nav-item nav-link">{{ __('Deconectare') }}</a>
</div>
