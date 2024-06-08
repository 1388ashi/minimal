<?php

namespace Modules\Core\App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $type,
        public string  $text
    )
    {
        //
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('core::components.badge');
    }
}
