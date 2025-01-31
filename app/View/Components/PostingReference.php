<?php

namespace App\View\Components;

use App\Models\PostingReferenceModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class PostingReference extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $tabindex;

    public function __construct($tabindex)
    {
        $this->tabindex = $tabindex;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user = Auth::user();
        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->where('pr_clg_id',$user->user_clg_id)->get();
        return view('components.posting-reference', compact('posting_references'));
    }
}
