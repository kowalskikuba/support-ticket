<?php

namespace App\Ticket\Service;

use App\Data\Entity\Ticket;
use App\Data\Repository\TicketRepository;
use App\Ticket\Async\SendTicketConfirmation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TicketService
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly MessageBusInterface $bus,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function save(Ticket $ticket): void
    {
        $this->entityManager->persist($ticket);
        $this->entityManager->flush();
        $this->bus->dispatch(new SendTicketConfirmation($ticket->getId()->toRfc4122()));
    }

    public function getAll(): array
    {
        return $this->ticketRepository->findAll();
    }
}
