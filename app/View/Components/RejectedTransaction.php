<?php

namespace App\View\Components;

use App\Models\RejectedEbookTransaction;
use App\Models\RejectedPodTransaction;
use Illuminate\View\Component;

class RejectedTransaction extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $count;

    public function __construct()
    {
        $rejectedpods = RejectedPodTransaction::where('quantity' ,'>' , 0)->count();
        $rejectedebooks = RejectedEbookTransaction::where('quantity' ,'>' , 0)->count();
        $this->count = $rejectedpods + $rejectedebooks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.rejected-transaction');
    }
}
