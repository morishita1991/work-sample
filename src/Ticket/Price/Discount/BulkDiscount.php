<?php
include_once 'Discount.php';
include_once './src/Ticket/AgeCategory/Child.php';

class BulkDiscount extends Discount
{
    const KEY = 1;
    const LABEL = '団体割引';
    const DISCOUNT_RATE = 10; // 10%割引
    const DISCOUNT_VALUE = 0;
    const CHILD_CONDITIONAL_VALUE = 0.5; // 子供は0.5人として換算する

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
        return $this->isOver10Tickets() && ($this->discountDetail[self::KEY] ?? 0) === 1;
    }

    /**
     * 10人以上かどうかを返す
     * @return bool
     */
    public function isOver10Tickets(): bool
    {
        $number = 0;
        foreach ($this->ticketDetail as $arr) {
            foreach ($arr as $key => $quantity) {
                if ($key === Child::KEY) {
                    $number += $quantity * self::CHILD_CONDITIONAL_VALUE;
                    continue;
                }
                $number += $quantity;
            }
        }
        return $number >= 10;
    }
}
