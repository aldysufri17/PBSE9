<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageForm extends Component
{
    public $title, $page, $route;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $page, $route)
    {
        $this->title = $title;
        $this->page = $page;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-form');
    }
}
