<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddRefreshButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $href;
    public $id;
    public function __construct($href,$id)
    {
        $this->href=$href;
        $this->id=$id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-refresh-button');
    }
}
