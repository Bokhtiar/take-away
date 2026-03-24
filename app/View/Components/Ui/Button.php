<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $type = 'button',
        public ?string $variant = 'primary',
        public ?string $size = 'md',
        public bool $disabled = false,
        public ?string $class = null,
        public ?string $href = null,
    ) {
    }

    public function render()
    {
        return view('components.ui.button');
    }
}

