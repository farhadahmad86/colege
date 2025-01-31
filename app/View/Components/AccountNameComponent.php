<?php

namespace App\View\Components;

use App\Traits\PartyNameTrait;
use Illuminate\View\Component;

class AccountNameComponent extends Component
{
    use PartyNameTrait;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $name;
    public $id;
    public $class;
    public $tabindex;
    public $title;
    public $href;
    public $array_index;

    public function __construct($name,$id,$class,$title,$tabindex,$href,$body)
    {

        $this->name=$name;
        $this->id=$id;
        $this->class=$class;
        $this->tabindex=$tabindex;
        $this->title=$title;
        $this->href=$href;
        $this->array_index=$body;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $accounts_array = $this->get_account_query($this->class);
        $accounts = $accounts_array[$this->array_index];

        return view('components.account-name-component',compact('accounts'));
    }
}
