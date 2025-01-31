<?php

namespace App\View\Components;

use App\Models\YearEndModel;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class YearEndComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $years;
    public $search;

    public function __construct($search)
    {
        $this->search=$search;
        $this->years = YearEndModel::orderBy('ye_id', 'DESC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.year-end-component');
    }
}
