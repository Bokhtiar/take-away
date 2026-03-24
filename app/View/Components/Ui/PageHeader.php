<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $class = null,
    ) {
    }

    public function render()
    {
        return view('components.ui.page-header');
    }
}

