<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class card extends Component
{
    /**
     * Create a new component instance.
     */
    public string $title, $route, $icon, $description, $color;
    public function __construct(string $title, string $route = '', string $icon, string $description = '', string $color)
    {
        $this->title = $title;
        $this->route = $route;
        $this->icon = $icon;
        $this->description = $description;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
