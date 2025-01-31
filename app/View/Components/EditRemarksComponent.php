<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditRemarksComponent extends Component
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
    public $value;
    public function __construct($id,$name,$tabindex,$title,$value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->tabindex = $tabindex;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.edit-remarks-component');
    }
}
