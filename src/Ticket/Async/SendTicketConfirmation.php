<?php

namespace App\Ticket\Async;

class SendTicketConfirmation
{
    public function __construct(
        public readonly string $ticketId
    ) {}
}
