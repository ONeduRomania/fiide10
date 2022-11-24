<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Acasă', route('home'));
});

Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Utilizatori', route('users.index'));
});

Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail, \App\Models\User $user) {
    $trail->parent('users.index');
    $trail->push($user->name, route('users.show', [$user->id]));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, \App\Models\User $user) {
    $trail->parent('users.show', $user);
    $trail->push('Editează', route('users.edit', [$user->id]));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Creează', route('users.create'));
});

Breadcrumbs::for('users.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Șterși', route('users.deleted'));
});


Breadcrumbs::for('schools.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Școli', route('schools.index'));
});

Breadcrumbs::for('schools.create', function (BreadcrumbTrail $trail) {
    $trail->parent('schools.index');
    $trail->push('Creează', route('schools.create'));
});

Breadcrumbs::for('schools.deleted', function (BreadcrumbTrail $trail) {
    $trail->parent('schools.index');
    $trail->push('Șterșe', route('schools.deleted'));
});

Breadcrumbs::for('schools.edit', function (BreadcrumbTrail $trail, \App\Models\School $school) {
    $trail->parent('schools.show', $school);
    $trail->push('Editează', route('schools.edit', [$school->id]));
});

Breadcrumbs::for('classes.index', function (BreadcrumbTrail $trail, \App\Models\School $school) {
    $trail->parent('schools.index');
    $trail->push($school->name, route('schools.show', [$school->id]));
    $trail->push('Clase', route('classes.index', [$school->id]));
});

Breadcrumbs::for('teachers.index', function (BreadcrumbTrail $trail, \App\Models\School $school) {
    $trail->parent('schools.index');
    $trail->push($school->name, route('schools.show', [$school->id]));
    $trail->push('Profesori', route('teachers.index', [$school->id]));
});

Breadcrumbs::for('subjects.index', function (BreadcrumbTrail $trail, \App\Models\School $school) {
    $trail->parent('schools.index');
    $trail->push($school->name, route('schools.show', [$school->id]));
    $trail->push('Materii', route('subjects.index', [$school->id]));
});

Breadcrumbs::for('subjects.create', function (BreadcrumbTrail $trail, \App\Models\School $school) {
    $trail->parent('subjects.index', $school);
    $trail->push('Creează', route('subjects.create', [$school->id]));
});

Breadcrumbs::for('subjects.show', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Subject $subject) {
    $trail->parent('subjects.index', $school);
    $trail->push($subject->name, route('subjects.show', [$school->id, $subject->id]));
});

Breadcrumbs::for('teachers.edit', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Teacher $teacher) {
    $trail->parent('teachers.index', $school);
    $trail->push($teacher->user->name, route('teachers.show', [$school->id, $teacher->id]));
});

Breadcrumbs::for('classes.show', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class) {
    $trail->parent('classes.index', $school);
    $trail->push($class->name, route('classes.show', [$school->id, $class->id]));
});

Breadcrumbs::for('timetable.index', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class) {
    $trail->parent('classes.show', $school, $class);
    $trail->push('Orar', route('timetable.index', [$school->id, $class->id]));
});

Breadcrumbs::for('log.create', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class) {
    $trail->parent('classes.show', $school, $class);
    $trail->push('Catalog', route('log.create', [$school->id, $class->id]));
});

Breadcrumbs::for('classes.student.show', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Student $student) {
    $trail->parent('classes.show', $school, $class);
    $trail->push($student->user->name, route('classes.student.show', [$school->id, $class->id, $student->id]));
});


Breadcrumbs::for('homework.index', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Subject $subject) {
    $trail->parent('home');
    $trail->push('Teme');
    $trail->push($subject->name, route('homework.index', [$school->id, $class->id, $subject->id]));
});

Breadcrumbs::for('homework.submit_get', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Subject $subject) {
    $trail->parent('homework.index', $school, $class, $subject);
    $trail->push('Trimite', route('homework.submit_get', [$school->id, $class->id, $subject->id]));
});

Breadcrumbs::for('homework.show', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Subject $subject, \App\Models\Homework $homework) {
    $trail->parent('homework.index', $school, $class, $subject);
    $trail->push($homework->name, route('homework.show', [$school->id, $class->id, $subject->id, $homework->id]));
});

Breadcrumbs::for('homework.edit', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Subject $subject, \App\Models\Homework $homework) {
    $trail->parent('homework.show', $school, $class, $subject, $homework);
    $trail->push('Editează', route('homework.edit', [$school->id, $class->id, $subject->id, $homework->id]));
});

Breadcrumbs::for('homework.create', function (BreadcrumbTrail $trail, \App\Models\School $school, \App\Models\Classroom $class, \App\Models\Subject $subject) {
    $trail->parent('homework.index', $school, $class, $subject);
    $trail->push('Creează', route('homework.create', [$school->id, $class->id, $subject->id]));

});
