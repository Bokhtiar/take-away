<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $name,
        public string $type = 'text',
        public ?string $value = null,
        public ?string $placeholder = null,
        public ?string $label = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $id = null,
        public ?string $class = null,
        public ?string $error = null,
    ) {
        $this->id = $id ?? $name;
    }

    public function render()
    {
        return view('components.ui.input');
    }
}

