<?php

namespace App\View\Components\Ui\Notifications;

use Illuminate\View\Component;

class Toast extends Component
{
    public function __construct(
        public string $type = 'success',
        public ?string $message = null,
        public bool $dismissible = true,
        public ?string $id = null,
    ) {
        $this->id = $id ?? 'toast-' . uniqid();
    }

    public function render()
    {
        return view('components.ui.notifications.toast');
    }
}
