<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageIndex extends Component
{
    public $title, $buttonLabel, $routeCreate;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $buttonLabel, $routeCreate)
    {
        $this->title = $title;
        $this->routeCreate = $routeCreate;
        $this->buttonLabel = $buttonLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-index');
    }
}
