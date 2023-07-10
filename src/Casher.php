<?php
include_once './src/Ticket/Ticket.php';
include_once './src/Ticket/Price/Discount/Discount.php';
include_once './src/Ticket/Price/ExtraCharge/ExtraCharge.php';

(new Casher)->Execute();

class Casher
{
    public function Execute()
    {
        $ticket = new Ticket();
        $ticket->register($ticket);
        
        $discount = new Discount($ticket);
        $discount->listen();
        
        $extraCharge = new ExtraCharge();
        $extraCharge->listen();
        
        $ticket->confirm();
        $discount->confirm();
        $extraCharge->confirm();

        $price = new Price($ticket, $discount, $extraCharge);
        $price->confirm();
        $price->listen();
    }
}
