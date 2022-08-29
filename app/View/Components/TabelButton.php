<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabelButton extends Component
{
    public $type, $title, $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $title, $color)
    {
        $this->type = $type;
        $this->title = $title;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tabel-button');
    }
}
