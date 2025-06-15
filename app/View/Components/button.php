<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class button extends Component
{
    public $link, $label, $color;
    /**
     * Create a new component instance.
     */
    public function __construct($link, $label, $color)
    {
        $this->link = $link;
        $this->label = $label;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
