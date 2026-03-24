<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $size = 'md',
        public bool $closeable = true,
    ) {
        $this->id = $id ?? 'modal-' . uniqid();
    }

    public function render()
    {
        return view('components.ui.modal');
    }
}

