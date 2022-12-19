<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Homework\DeleteFileFromSubmission;
use App\Http\Requests\Homework\StoreHomeworkRequest;
use App\Http\Requests\SubmitHomeworkRequest;
use App\Mail\HomeworkDueDateChanged;
use App\Mail\NewHomework;
use App\Models\Classroom;
use App\Models\Homework;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubmittedHomework;
use App\Models\Teacher;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeworkController extends Controller
{
    private const PER_PAGE = 5;

    public function index(School $school, Classroom $class, Request $request)
    {
        $current_page = $request->get('page', '1');
        $subjectId = $request->get('subject');
        $homeworks = Homework::withCount('submissions')->where('class_id', $class->id);
        if (null != $subjectId) {
            $homeworks = $homeworks->where('subject_id', $subjectId);
        }
        $homeworks = $homeworks->orderBy('id', 'DESC')->paginate(self::PER_PAGE, $current_page);

        return view('dashboard.school.class.homework.index', compact('school', 'class', 'homeworks'));
    }

    public function create(Request $request, School $school, Classroom $class)
    {
        $current_user = $request->user();
        $teacher_instance = Teacher::whereUserId($current_user->id)->first();
        if (null == $teacher_instance) {
            return redirect()
                ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                ->withErrors('Doar profesorii pot crea teme.')
                ->withInput()
            ;
        }

        $subjects = $teacher_instance->subjects;

        return view('dashboard.school.class.homework.new', compact('school', 'class', 'subjects'));
    }

    public function edit(School $school, Classroom $class, Homework $homework)
    {
        $filetypes = json_decode($homework->filetypes ?? '[]', true);

        return view('dashboard.school.class.homework.edit', compact('school', 'class', 'homework', 'filetypes'));
    }

    public function store(School $school, Classroom $class, StoreHomeworkRequest $request): RedirectResponse
    {
        try {
            // Assign the homework to the currently logged in teacher
            /** @var User $currentUser */
            $currentUser = $request->user();
            $teacher = Teacher::where('user_id', $currentUser->id)->get()->first();

            $homework = new Homework();
            $homework->class_id = $class->id;
            $homework->subject_id = $request->subject;
            $homework->teacher_id = $teacher->id;
            $homework->due_date = $request->due_date;
            $homework->name = $request->name;

            $formats = $this->populateFormatArray($request);
            $homework->filetypes = json_encode($formats);
            $homework->save();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.create', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput()
            ;
        }

        try {
            $subject = Subject::find($request->subject);
            $students = Student::where('class_id', $class->id)->get();
            foreach ($students as $student) {
                $studUser = $student->user;
                \Mail::to($studUser)->send(new NewHomework($homework, $subject));
            }
            unset($student);
        } catch (\Exception $e) {
            // TODO: Log failure
        }

        return redirect()->route('homework.index', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Tema a fost adăugată cu succes.'),
        ]);
    }

    public function update(School $school, Classroom $class, Homework $homework, StoreHomeworkRequest $request)
    {
        $shouldSendMail = false;

        try {
            if (null != $request->due_date) {
                $homework->due_date = $request->due_date;
                $shouldSendMail = true;
            }

            if (null != $request->name) {
                $homework->name = $request->name;
            }

            $formats = $this->populateFormatArray($request);
            $homework->filetypes = json_encode($formats);

            $homework->save();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput()
            ;
        }

        if ($shouldSendMail) {
            try {
                $subject = Subject::find($homework->subject_id);
                $students = Student::where('class_id', $class->id)->get();
                foreach ($students as $student) {
                    $studUser = $student->user;
                    \Mail::to($studUser)->send(new HomeworkDueDateChanged($homework, $subject));
                }
                unset($student);
            } catch (\Exception $e) {
                // TODO: Log failure
            }
        }

        return redirect()->route('homework.index', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Tema a fost editată cu succes.'),
        ]);
    }

    public function destroy(School $school, Classroom $class, Homework $homework)
    {
        try {
            $homework->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput()
            ;
        }

        return redirect()->route('homework.index', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Tema a fost ștearsă cu succes.'),
        ]);
    }

    public function show(School $school, Classroom $class, Homework $homework, Request $request)
    {
        $current_page = $request->get('page', '1');
        $submissions = SubmittedHomework::with('student')->where('homework_id', '==', $homework->id)->paginate(self::PER_PAGE, $current_page);

        return view('dashboard.school.class.homework.show', compact('school', 'class', 'homework', 'submissions'));
    }

    public function downloadHomeworkFiles(School $school, Classroom $class, Homework $homework, SubmittedHomework $submission)
    {
        $urls = json_decode($submission->uploaded_urls, true);
        if (0 == count($urls)) {
            return redirect()->route('homework.index', ['school' => $school->id, 'class' => $class->id])->withErrors('Nu există niciun fișier de descărcat.');
        }

        if (count($urls) > 1) {
            $student = Student::whereId($submission->student_id)->first();
            if (null != $student) {
                $fName = $homework->name.' - '.$student->user->name;
            } else {
                $fName = $homework->name.' - '.$submission->id;
            }

            $zip = new \ZipArchive();
            $fileName = tempnam(sys_get_temp_dir(), 'fiidezece_');
            if (true !== $zip->open($fileName, \ZipArchive::CREATE)) {
                // TODO: Report
                return redirect()
                    ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                    ->withErrors('A apărut o eroare în descărcarea temei. Te rugăm să contactezi echipa de suport.')
                    ->withInput()
                ;
            }
            foreach ($urls as $downloadedFileName => $fileData) {
                try {
                    $fileContents = \Storage::cloud()->get($fileData['path']);
                    $zip->addFromString($downloadedFileName, $fileContents);
                } catch (FileNotFoundException $e) {
                    // TODO: Report
                    return redirect()
                        ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                        ->withErrors('A apărut o eroare în descărcarea temei. Te rugăm să contactezi echipa de suport.')
                        ->withInput()
                    ;
                }
            }
            $zip->close();

            return \Storage::disk('root')->download('/'.$fileName, $fName.'.zip');
        }

        $fileName = array_key_first($urls);

        return \Storage::cloud()->download($urls[$fileName]['path'], $fileName);
    }

    public function getHomeworkForStudent(School $school, Classroom $class, Request $request)
    {
        // This parameter controls whether we should show all the homeworks or only the unsubmitted ones.
        $shouldShowAll = $request->query('all');

        if ($shouldShowAll) {
            $homeworks = Homework::where('class_id', $class->id)->get();
        } else {
            /** @var User $currentUser */
            $currentUser = $request->user();
            $studentEntity = Student::where('user_id', $currentUser->id)->first();
            if (null == $studentEntity) {
                return redirect('welcome');
            }

            $homeworks = Homework::whereNotExists(function ($query) use ($studentEntity) {
                $tableName = app(SubmittedHomework::class)->getTable(); // Get the table name in case it changes
                $homeworkTableName = app(Homework::class)->getTable();
                $query->select(DB::raw(1))
                    ->from($tableName)
                    ->where("{$tableName}.student_id", $studentEntity->id)
                    ->whereColumn("{$tableName}.homework_id", "{$homeworkTableName}.id")
                ;
            })->get();
        }

        foreach ($homeworks as $homework) {
            $homework->subject = Subject::whereId($homework->subject_id)->first();
        }
        unset($homework);

        return view('dashboard.school.class.homework.student_index', compact('homeworks', 'school', 'class', 'shouldShowAll'));
    }

    public function submitHomework(School $school, Classroom $class, Homework $homework, Request $request)
    {
        $currentUser = $request->user();
        $studentEntity = Student::where('user_id', $currentUser->id)->first();
        if (null == $studentEntity) {
            return redirect('welcome');
        }

        $mimeTypes = '';
        $fileTypes = json_decode($homework->filetypes, true);
        foreach ($fileTypes as $type) {
            $mime = MimeType::fromExtension($type);
            $mimeTypes = $mimeTypes.','.$mime;
        }
        $mimeTypes = json_encode($mimeTypes);

        /** @var null|SubmittedHomework $submission */
        $submission = SubmittedHomework::where('homework_id', $homework->id)->where('student_id', $studentEntity->id)->get()->first();
        $uploadedUrls = [];
        if (null != $submission) {
            foreach (json_decode($submission->uploaded_urls, true) as $fileName => $fileData) {
                $uploadedUrls[]['name'] = $fileName;
            }
        }
        $uploadedUrls = json_encode($uploadedUrls);

        return view('dashboard.school.class.homework.submit', compact('school', 'class', 'homework', 'mimeTypes', 'uploadedUrls'));
    }

    public function turnIn(School $school, Classroom $class, Homework $homework, SubmitHomeworkRequest $request)
    {
        /**
         * We get the student in the authorize() method of the request.
         *
         * @var Student $studentEntity
         */
        $studentEntity = $request->student;

        $files = $request->file('file');
        if (null == $files) {
            return redirect()
                ->route('homework.index', ['school' => $school->id, 'class' => $class->id])
                ->withErrors(__('Te rugăm să te asiguri că ai încărcat fișierele și să încerci din nou.'))
            ;
        }

        try {
            /** @var null|SubmittedHomework $submission */
            $submission = SubmittedHomework::where('homework_id', $homework->id)->where('student_id', $studentEntity->id)->get()->first();
            if (null == $submission) {
                $submission = new SubmittedHomework();
                $submission->student_id = $studentEntity->id;
                $submission->homework_id = $homework->id;
                $submission->uploaded_urls = '[]';
            }
            $uploadedUrls = json_decode($submission->uploaded_urls, true);

            foreach ($files as $file) {
                $fileName = $files->getClientOriginalName();
                $successful = \Storage::cloud()->putFileAs('student-'.$studentEntity->id, $file, Str::random(5).$fileName);
                if (!$successful) {
                    // TODO: Report
                    throw new \Exception('Failed file upload');
                }
                $uploadUrl = \Storage::cloud()->url($successful);
                $uploadedUrls[$fileName] = [
                    'name' => $fileName,
                    'url' => $uploadUrl,
                    'path' => $successful,
                    'uploadTime' => time(),
                ];
            }
            $submission->uploaded_urls = json_encode($uploadedUrls);

            $submission->save();
        } catch (\Exception $e) {
            // TODO: Log
            return redirect()
                ->route('homework.submit_get', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id])
                ->withErrors(__('A apărut o eroare. Te rugăm să încerci din nou.'))
            ;
        }

        return redirect()->route('homework.index', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Tema a fost trimisă cu succes.'),
        ]);
    }

    public function deleteFileFromSubmission(School $school, Classroom $class, Homework $homework, DeleteFileFromSubmission $request)
    {
        $currentValues = json_decode($request->submission->uploaded_urls, true);
        $valueToDelete = $request->file_name;

        // Verify that the file exists
        if (!array_key_exists($valueToDelete, $currentValues)) {
            return redirect()
                ->route('homework.submit_get', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id])
                ->withErrors('Fișierul care a fost specificat nu există.')
            ;
        }

        // Delete the file from storage
        \Storage::cloud()->delete($currentValues[$valueToDelete]['path']);

        // Delete the file from the database
        unset($currentValues[$valueToDelete]);
        $request->submission->uploaded_urls = json_encode($currentValues);
        $request->submission->save();

        return redirect()
            ->route('homework.submit_get', ['school' => $school->id, 'class' => $class->id, 'homework' => $homework->id])
            ->with([
                'success' => __('Tema a fost ștearsă cu succes.'),
            ])
        ;
    }

    /**
     * @return array|string[]
     *
     * @throws \Exception
     */
    public function populateFormatArray(StoreHomeworkRequest $request): array
    {
        $formats = [];
        if ('on' === $request->accept_word_upload) {
            $formats = array_merge($formats, ['doc', 'docx', 'odt']);
        }
        if ('on' === $request->accept_pdf_upload) {
            $formats = array_merge($formats, ['pdf']);
        }
        if ('on' === $request->accept_image_upload) {
            $formats = array_merge($formats, ['png', 'jpg', 'bmp', 'jpeg']);
        }
        if ('on' === $request->accept_code_upload) {
            $formats = array_merge($formats, ['c', 'cpp', 'cs', 'pas', 'dart', 'r', 'rb', 'dart', 'js', 'ts', 'php', 'm', 'kt', 'swift', 'java']);
        }
        if ('on' === $request->accept_archive_upload) {
            $formats = array_merge($formats, ['rar', 'zip', '7z', 'gz']);
        }

        $formats = array_unique($formats);
        if (0 == count($formats)) {
            throw new \Exception(__('Selectează măcar un tip de fișiere!'));
        }

        return $formats;
    }
}
