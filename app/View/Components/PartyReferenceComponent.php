<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PartyReferenceComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $id;
//    public $class;
    public $tabindex;
    public function __construct($id,$name,$tabindex)
    {
        $this->id = $id;
        $this->name = $name;
        $this->tabindex = $tabindex;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.party-reference-component');
    }
}
