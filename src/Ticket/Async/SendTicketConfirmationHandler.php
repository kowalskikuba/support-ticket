<?php

namespace App\Ticket\Async;

use App\Data\Repository\TicketRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final class SendTicketConfirmationHandler
{
    public function __construct(
        private TicketRepository $tickets,
        private MailerInterface $mailer,
    ) {}

    public function __invoke(SendTicketConfirmation $message): void
    {
        $ticket = $this->tickets->find($message->ticketId);
        if (!$ticket) {
            throw new \RuntimeException('Ticket not found: '.$message->ticketId);
        }

        $email = (new Email())
            ->from('support@example.test')
            ->to($ticket->getEmail())
            ->subject('Ticket received: '.$ticket->getSubject())
            ->text("Thanks! We received your ticket.\n\n".$ticket->getMessage());

        $this->mailer->send($email);
    }
}
