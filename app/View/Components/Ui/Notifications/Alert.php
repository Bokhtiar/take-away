<?php

namespace App\View\Components\Ui\Notifications;

use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public string $type = 'info',
        public ?string $message = null,
        public bool $dismissible = true,
        public ?string $icon = null,
    ) {
    }

    public function render()
    {
        return view('components.ui.notifications.alert');
    }
}

