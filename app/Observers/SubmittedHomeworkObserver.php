<?php

namespace App\Observers;

use App\SubmittedHomework;

class SubmittedHomeworkObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param SubmittedHomework $submission
     * @return void
     */
    public function created(SubmittedHomework $submission)
    {
        // TODO: Notify the teacher
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param SubmittedHomework $submission
     * @return void
     */
    public function deleted(SubmittedHomework $submission)
    {
        $files = json_decode($submission->uploaded_urls, true);
        foreach ($files as $fileData) {
            \Storage::cloud()->delete($fileData["path"]);
        }
    }
}
