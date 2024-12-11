<?php

namespace OCA\Helloworld\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AddEvent extends Event {
    private string $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    public function getMessage(): string {
        return $this->message;
    }
}
