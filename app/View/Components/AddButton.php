<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $href;
    public $tabindex;
    public function __construct($href,$tabindex)
    {
        $this->href=$href;
        $this->tabindex=$tabindex;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-button');
    }
}
