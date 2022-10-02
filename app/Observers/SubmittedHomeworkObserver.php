<?php

namespace App\Observers;

use App\SubmittedHomework;

class SubmittedHomeworkObserver
{
    /**
     * Handle the SubmittedHomework "deleted" event.
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
