<?php

namespace App\Mail;

use App\Homework;
use App\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HomeworkDueDateChanged extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Homework */
    public $homework;

    /** @var Subject */
    public $schoolSubject;

    /**
     * Create a new message instance.
     *
     * @param Homework $homework
     * @param Subject $schoolSubject
     * @return void
     */
    public function __construct(Homework $homework, Subject $schoolSubject)
    {
        $this->homework = $homework;
        $this->schoolSubject = $schoolSubject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->subject("Fii de 10 - Data limită schimbată pentru tema la " . $this->schoolSubject->name)->view('mail.homework_due_date_changed');
    }
}
