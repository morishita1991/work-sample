<?php
include_once 'Discount.php';

class MondayWednesDayDiscount extends Discount
{
    const KEY = 3;
    const LABEL = '月水割引';
    const DISCOUNT_RATE = 0;
    const DISCOUNT_VALUE = 100; //100円引き

    private array $discountDetail;

    public function __construct(Discount $discount)
    {
        $this->discountDetail = $discount->detail;
    }

    /**
     * 割引を適用するかどうかを返す
     * @return bool
     */
    public function applicable(): bool
    {
        // ⽉曜または⽔曜かどうか(曜日判定は行っていない)
        $isMondayOrWednesDay = true;
        return $isMondayOrWednesDay && $this->discountDetail[self::KEY] === 1;
    }
}