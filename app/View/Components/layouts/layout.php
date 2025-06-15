<?php

namespace App\View\Components\layouts;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class layout extends Component
{
    public $titleApps, $slot;
    /**
     * Create a new component instance.
     */
    public function __construct($titleApps = '', $slot = '')
    {
        $this->titleApps = $titleApps;
        $this->slot = $slot;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.layout');
    }
}
