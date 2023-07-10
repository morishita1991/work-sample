<?php
include_once 'Discount.php';

class EveningDiscount extends Discount
{
    const KEY = 2;
    const LABEL = '夕方料金';
    const DISCOUNT_RATE = 0;
    const DISCOUNT_VALUE = 100; //100円引き

    private array $discountDetail;

    public function __construct(Discount $discount)
    {
        $this->discountDetail = $discount->detail;
    }

    /**
     * 割引の適用可否を返す
     * @return bool
     */
    public function applicable(): bool
    {
        // 夕方17時以降かどうか(時刻判定は行っていない)
        $isEvening = true;
        return $isEvening && ($this->discountDetail[self::KEY] ?? 0) === 1;
    }
}