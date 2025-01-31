<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RemarksComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $id;
    public $title;
    public $tabindex;
    public function __construct($id,$name,$tabindex,$title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->tabindex = $tabindex;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.remarks-component');
    }
}
