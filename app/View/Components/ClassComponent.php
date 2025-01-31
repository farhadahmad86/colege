<?php

namespace App\View\Components;

use App\Models\College\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ClassComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $search_class;
    public $name;
    public $id;
    public function __construct($name,$id,$search=null)
    {
        $this->search_class=$search;
        $this->name=$name;
        $this->id=$id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {  $user = Auth::user();
        $classes = Classes::where('class_clg_id',$user->user_clg_id)->where('class_disable_enable','=',1)->get();
        return view('components.class-component', compact('classes'));
    }
}
