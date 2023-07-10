<?php
include_once './Ticket/TicketType/TicketType.php';

(new UnitTest)->testListenTicketType();

class UnitTest
{
    /**
     * チケット種別
     */
    public function testListenTicketType()
    {
        $ticketType = new TicketType();
        $ticketType->listen();
    }
}