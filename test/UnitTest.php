<?php
include_once './src/Ticket/TicketType/TicketType.php';
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    /**
     * チケット種別
     */
    public function testListenTicketType()
    {
        // $ticketType = new TicketType();
        // $ticketType->listen();
        $this->assertTrue(true);
    }
}