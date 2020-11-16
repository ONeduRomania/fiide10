<?php

namespace App\View\Components;

use Str, Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class BreadcrumbComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $uris = Str::of(Route::current()->uri)->explode('/');

        return view('components.breadcrumb-component', compact('uris'));
    }
}
