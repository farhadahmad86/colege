<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SalemanComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $sale_persons;
    public function __construct()
    {
        $user = Auth::user();
        $this->sale_persons = User::where('user_delete_status', '!=', 1)->where('user_clg_id',$user->user_clg_id)->where('user_role_id', '=', 4)->orderBy('user_name', 'ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.saleman-component');
    }
}
