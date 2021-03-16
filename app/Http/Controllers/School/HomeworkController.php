<?php

namespace App\Http\Controllers\School;

use App\Classroom;
use App\Homework;
use App\Http\Controllers\Controller;
use App\Http\Requests\Homework\StoreHomeworkRequest;
use App\Http\Requests\SubmitHomeworkRequest;
use App\School;
use App\Student;
use App\Subject;
use App\SubmittedHomework;
use App\Teacher;
use App\User;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeworkController extends Controller
{
    public function getHomeworkForSubject(School $school, Classroom $classroom, Subject $subject, Request $request)
    {
        $homeworks = \App\Homework::withCount('submissions')->where('subject_id', $subject->id)->where('class_id', $classroom->id)->orderBy('id', 'DESC')->get();

        return view('dashboard.school.class.homework.index', compact('school', 'classroom', 'homeworks', 'subject'));

    }

    public function createHomeworkForSubject(School $school, Classroom $classroom, Subject $subject, StoreHomeworkRequest $request): RedirectResponse
    {
        try {

            // Assign the homework to the currently logged in teacher
            /** @var User $currentUser */
            $currentUser = $request->user();
            $teacher = Teacher::where('user_id', $currentUser->id)->get()->first();

            $homework = new Homework();
            $homework->class_id = $classroom->id;
            $homework->subject_id = $subject->id;
            $homework->teacher_id = $teacher->id;
            $homework->due_date = $request->due_date;
            $homework->name = $request->name;

            $formats = $this->populateFormatArray($request, []);
            $homework->filetypes = json_encode($formats);
            $homework->save();

        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost adăugată cu succes.')
        ]);
    }

    public function updateHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework, StoreHomeworkRequest $request)
    {
        try {
            if ($request->due_date != null) {
                $homework->due_date = $request->due_date;
                // TODO: Trimite notificare pentru data schimbată dacă e cazul
            }

            if ($request->name != null) {
                $homework->name = $request->name;
            }

            $formats = json_decode($homework->filetypes, true);
            $formats = $this->populateFormatArray($request, $formats);

            $homework->filetypes = json_encode($formats);

            $homework->save();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost editată cu succes.')
        ]);
    }

    public function deleteHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework)
    {
        try {
            $homework->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost ștearsă cu succes.')
        ]);
    }

    public function checkHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework)
    {
        $submittedHomeworks = $homework->submissions;
        foreach ($submittedHomeworks as $submission) {
            $submission->student = Student::whereId($submission->student_id)->first();
        }
        return view('dashboard.school.class.homework.show', compact('school', 'classroom', 'homework', 'subject'));
    }

    public function downloadHomeworkFiles(School $school, Classroom $classroom, Subject $subject, Homework $homework, SubmittedHomework $submission)
    {
        $urls = json_decode($submission->uploaded_urls, true);
        if (count($urls) == 0) {
            return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->withErrors('Nu există niciun fișier de descărcat.');
        }

        if (count($urls) > 1) {
            $student = Student::whereId($submission->student_id)->first();
            if ($student != null) {
                $fName = $homework->name . " - " . $student->user->name;
            } else {
                $fName = $homework->name . " - " . $submission->id;
            }

            $zip = new \ZipArchive();
            $fileName = tempnam(sys_get_temp_dir(), 'fiidezece_');
            if ($zip->open($fileName, \ZipArchive::CREATE) !== TRUE) {
                // TODO: Report
                return redirect()
                    ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                    ->withErrors("A apărut o eroare în descărcarea temei. Te rugăm să contactezi echipa de suport.")
                    ->withInput();
            }
            foreach ($urls as $downloadedFileName => $fileData) {
                try {
                    $fileContents = \Storage::cloud()->get($fileData["path"]);
                    $zip->addFromString($downloadedFileName, $fileContents);
                } catch (FileNotFoundException $e) {
                    // TODO: Report
                    return redirect()
                        ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                        ->withErrors("A apărut o eroare în descărcarea temei. Te rugăm să contactezi echipa de suport.")
                        ->withInput();
                }
            }
            $zip->close();
            return \Storage::disk('root')->download("/" . $fileName, $fName . ".zip");
        }

        $fileName = array_key_first($urls);
        return \Storage::cloud()->download($urls[$fileName]["path"], $fileName);

    }

    public function getHomeworkForStudent(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }

    public function getDueHomeworkFromStudent(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }

    public function submitHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework)
    {
        $mimeTypes = "";
        $fileTypes = json_decode($homework->filetypes, true);
        foreach ($fileTypes as $type) {
            $mime = MimeType::fromExtension($type);
            $mimeTypes = $mimeTypes . "," . $mime;
        }
        $mimeTypes = json_encode($mimeTypes);
        return view('dashboard.school.class.homework.submit', compact('school', 'classroom', 'homework', 'subject', 'mimeTypes'));

    }

    public function turnIn(School $school, Classroom $classroom, Subject $subject, Homework $homework, SubmitHomeworkRequest $request)
    {

        /**
         * We get the student in the authorize() method of the request.
         *
         * @var Student $studentEntity
         */
        $studentEntity = $request->student;

        $file = $request->file('file');
        if ($file == null) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors(__("Te rugăm să te asiguri că ai încărcat fișierele și să încerci din nou."));
        }
        $fileName = $file->getClientOriginalName();
        try {
            $successful = \Storage::cloud()->putFileAs('student-' . $studentEntity->id, $file, Str::random(5) . $fileName);
            if (!$successful) {
                // TODO: Report
                throw new \Exception("Failed file upload");
            }
            $uploadUrl = \Storage::cloud()->url($successful);

            /** @var SubmittedHomework|null $submission */
            $submission = SubmittedHomework::where('homework_id', $homework->id)->get()->first();
            if ($submission == null) {
                $submission = new SubmittedHomework();
                $submission->student_id = $studentEntity->id;
                $submission->homework_id = $homework->id;
                $submission->uploaded_urls = [];
            }

            $uploadedUrls = json_decode($submission->uploaded_urls, true);
            $uploadedUrls[$fileName] = [
                "name" => $fileName,
                "url" => $uploadUrl,
                "path" => $successful,
                "uploadTime" => time()
            ];
            $submission->uploaded_urls = json_encode($uploadedUrls);

            $submission->save();
        } catch (\Exception $e) {
            // TODO: Log
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors("A apărut o eroare la încărcarea temei. Promitem că ne vom ocupa de ea și revenim!")
                ->withInput();
        }

        return view('dashboard.school.class.homework.show', compact('school', 'classroom', 'homework', 'subject'));

    }

    /**
     * @param StoreHomeworkRequest $request
     * @return StoreHomeworkRequest
     */
    public function populateFormatsArray(StoreHomeworkRequest $request): StoreHomeworkRequest
    {
        return $request;
    }

    /**
     * @param StoreHomeworkRequest $request
     * @param array $formats
     * @return mixed
     * @throws \Exception
     */
    public function populateFormatArray(StoreHomeworkRequest $request, array $formats)
    {
        if ($request->accept_word_upload === "on") {
            $formats = array_merge($formats, ["doc", "docx", "odt"]);
        }
        if ($request->accept_pdf_upload === "on") {
            $formats = array_merge($formats, ["pdf"]);
        }
        if ($this->populateFormatsArray($request)->accept_image_upload === "on") {
            $formats = array_merge($formats, ["png", "jpg", "bmp", "jpeg"]);
        }
        if ($request->accept_code_upload === "on") {
            $formats = array_merge($formats, ["c", "cpp", "cs", "pas", "dart", "r", "rb", "dart", "js", "ts", "php", "m", "kt", "swift", "java"]);
        }
        if ($request->accept_archive_upload === "on") {
            $formats = array_merge($formats, ["rar", "zip", "7z", "gz"]);
        }

        $formats = array_unique($formats);
        if (count($formats) == 0) {
            throw new \Exception(__("Selectează măcar un tip de fișiere!"));
        }
        return $formats;
    }
}
