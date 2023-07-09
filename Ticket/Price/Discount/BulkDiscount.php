<?php
include_once 'Discount.php';

class BulkDiscount extends Discount
{
    const KEY = 1;
    const LABEL = '団体割引';
    const DISCOUNT_RATE = 10; // 10%割引
    const DISCOUNT_VALUE = 0;

    private array $discountDetail;
    private int $quantity;

    public function __construct(Discount $discount, Quantity $quantity)
    {
        $this->discountDetail = $discount->detail;
        $this->quantity = $quantity->quantity;
    }

    /**
     * 割引を適用するかどうかを返す
     * @return bool
     */
    public function applicable(): bool
    {
        // 10人以上かどうか
        return $this->quantity >= 10 && $this->discountDetail[self::KEY] === 1;
    }
}
