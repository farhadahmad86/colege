<?php

namespace App\View\Components;

use App\Models\WarehouseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class WarehouseComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $tabindex;
    public $name;
    public $id;
    public $class;
    public $title;

    public function __construct($tabindex,$name,$id,$class,$title)
    {
        $this->tabindex=$tabindex;
        $this->name=$name;
        $this->id=$id;
        $this->class=$class;
        $this->title=$title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user = Auth::user();
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_clg_id',$user->user_clg_id)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();
        return view('components.warehouse-component',compact('warehouses'));
    }
}
