<?php

namespace App\View\Components;

use App\Homework;
use Illuminate\View\Component;

class HomeworkForm extends Component
{

    /**
     * @var Homework
     */
    public Homework $homework;

    /**
     * Create a new component instance.
     *
     * @param Homework $homework
     */
    public function __construct(Homework $homework)
    {
        $this->homework = $homework;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.homework-form');
    }
}
