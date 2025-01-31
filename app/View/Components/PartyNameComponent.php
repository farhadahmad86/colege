<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Traits\PartyNameTrait;

class PartyNameComponent extends Component
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
    public $select_uid;
    public $label_name;

    public function __construct($id, $name, $class, $tabindex)
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->tabindex = $tabindex;
        if ($class == 'sale') {
            $this->select_uid = 110161;
        } elseif ($class == 'purchase') {
            $this->select_uid = 210121;
        }
        if ($name == 'account_name') {
            $this->label_name = 'Name';
        } elseif ($name == 'account_code') {
            $this->label_name = 'Code';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $accounts = $this->get_account_query($this->class)[0];
        return view('components.party-name-component', compact('accounts'));
    }
}
