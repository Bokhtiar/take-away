<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class File extends Component
{
    public function __construct(
        public string $name,
        public ?string $label = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $id = null,
        public ?string $class = null,
        public ?string $error = null,
        public ?string $accept = null,
        public bool $multiple = false,
    ) {
        $this->id = $id ?? $name;
    }

    public function render()
    {
        return view('components.ui.file');
    }
}

