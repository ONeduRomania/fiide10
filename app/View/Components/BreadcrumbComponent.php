<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;

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
     * @return View|string
     */
    public function render()
    {
        $route = Route::current();
        $initialUris = Str::of($route->uri)->explode('/');
        $uris = [];
        foreach ($initialUris as $uri) {
            if (Str::startsWith($uri, "{") && Str::endsWith($uri, "}")) {
                // This is probably a parameter
                $paramName = Str::substr($uri, 1, strlen($uri) - 2);
                $param = $route->parameter($paramName);
                // Try to find a name for this entity
                if (isset($param->name)) {
                    $uris[] = $param->name;
                } else {
                    // Fallback to the original value if we cannot find it
                    $uris[] = $uri;
                }
            } else {
                // If it is not a parameter, add it as is
                $uris[] = $uri;
            }

        }

        return view('components.breadcrumb-component', compact('uris'));
    }
}
