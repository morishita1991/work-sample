<?php
include_once './TicketType.php';
include_once './AgeCategory.php';
include_once './NumberOfTickets.php';
include_once './Ticket.php';

class Controller
{
    public function execute(Ticket $ticket)
    {
        $ticketType = new TicketType();
        $ticketType->listen();
        
        $ageCategory = new AgeCategory();
        $ageCategory->listen();
        
        $numberOfTickets = new NumberOfTickets();
        $numberOfTickets->listen();
        
        $ticket->add($ticketType, $ageCategory, $numberOfTickets);
        $ticket->confirm();
        $ticket->listen();
    }
}