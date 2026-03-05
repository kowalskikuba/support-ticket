<?php

namespace App\Ticket\Controller;

use App\Data\Entity\Ticket;
use App\Ticket\Form\TicketType;
use App\Ticket\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'ticket_list')]
    public function index(TicketService $ticketService): Response
    {
        $tickets = $ticketService->getAll();

        return $this->render('ticket/list.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/ticket/create', name: 'ticket_create')]
    public function create(Request $request, TicketService $ticketService): Response
    {
        $ticket = new Ticket();

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticketService->save($ticket);

            $this->addFlash('success', 'Ticket created!');

            return $this->redirectToRoute('ticket_list');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
