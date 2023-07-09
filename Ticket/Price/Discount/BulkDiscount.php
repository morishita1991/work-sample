<?php
include_once 'Discount.php';

class BulkDiscount extends Discount
{
    const KEY = 1;
    const LABEL = '団体割引';
    const DISCOUNT_RATE = 10; // 10%割引
    const DISCOUNT_VALUE = 0;

    private array $discountDetail;
    private array $ticketDetail;

    public function __construct(Discount $discount, Ticket $ticket)
    {
        $this->discountDetail = $discount->detail;
        $this->ticketDetail = $ticket->detail;
    }

    /**
     * 割引の適用可否を返す
     * @return bool
     */
    public function applicable(): bool
    {
        // 10人以上かどうか
        $number = 0;
        foreach ($this->ticketDetail as $arr) {
            foreach ($arr as $key => $quantity) {
                $number += $quantity;
            }
        }
        return $number >= 10 && ($this->discountDetail[self::KEY] ?? 0) === 1;
    }
}
