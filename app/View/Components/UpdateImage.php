<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpdateImage extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $image;
    public function __construct($title, $image)
    {
        $this->title=$title;
        $this->image=$image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.update-image');
    }
}
