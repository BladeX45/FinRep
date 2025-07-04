<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class alert extends Component
{
    public $message, $field;
    /**
     * Create a new component instance.
     */
    public function __construct($message = '', $field = '')
    {
        $this->message = $message;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
