<?php

namespace Tests\Feature;

use App\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeworkTest extends TestCase
{
    /**
     * This basic test ensures that if a user tries to access the homework list without being logged in, they get
     * redirected to the login page.
     *
     * @return void
     */
    public function testRedirectToLoginWhenTryingToAccessHomeworkListUnauthenticated()
    {
        $response = $this->get('/school/2/classes/2/homework/2');

        $response->assertStatus(302);
    }

    public function testShowsHomeworkListForTeacher()
    {
        // TODO: Create teacher if they don't exist
        $teacher = Teacher::query()->first()->get()->first();
        $user = $teacher->user;
        $response = $this->actingAs($user)->get('/school/2/classes/2/homework/2');

        $response->assertStatus(302);
    }

    public function testStudentCannotAccessFullHomeworkList()
    {
        // TODO: Create
    }

    public function testBadSubjectIdShowsProperError()
    {
        // TODO: Create
    }

    public function testTeacherCanCreateHomeworkForSubject()
    {
        // TODO: Create
    }

    public function testStudentCannotCreateHomeworkForSubject()
    {
        // TODO: Create
    }

    public function testHomeworkCanOnlyHaveFutureDueDate()
    {
        // TODO: Create
    }

    public function testHomeworkCannotBeCreatedWithoutTeacher()
    {
        // TODO: Create (and see if it conflicts with the student creation test)
    }

    public function testStudentCanSeeHisDueHomework()
    {
        // TODO: Create
    }

    public function testStudentCanSeeHisPastHomeworkForSubject()
    {
        // TODO: Create
    }

    public function testStudentCanTurnInHomework()
    {
        // TODO: Create
    }

    public function testStudentCanOnlyTurnInHisOwnHomework()
    {
        // TODO: Create
    }

    public function testStudentCannotSubmitHomeworkForNonexistentHomework()
    {
        // TODO: Create
    }
}
