<?php

namespace App\View\Components;

use App\Models\College\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Session;

class BranchComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $branches;


    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $query = Branch::query();
        if ($user->user_id != 1) {
            if ($user->user_branch_id != 1) {
                $this->branches = DB::select('select * from branches where branch_id  IN (' . $branch_id . ') and branch_clg_id = ' . $user->user_clg_id);
            } else {
                $query->where('branch_clg_id', $user->user_clg_id)->get();
            }


        } else {
            $this->branches = $query->get();
        }

        return view('components.branch-component');
    }
}
