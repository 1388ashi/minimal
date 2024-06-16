<?php

namespace Modules\Core\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

class DeleteBtn extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $route,
        public Model $model,
        public bool $disabled = false
    )
    {
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('core::components.delete-btn');
    }
}
