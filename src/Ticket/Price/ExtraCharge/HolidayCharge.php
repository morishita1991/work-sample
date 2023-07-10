<?php

class HolidayCharge extends ExtraCharge
{
    const KEY = 1;
    const LABEL = '休日料金';
    const CHARGE_RATE = 0;
    const CHARGE_VALUE = 200; //200円割増

    private array $ExtraChargeDetail;

    public function __construct(ExtraCharge $extraCharge)
    {
        $this->ExtraChargeDetail = $extraCharge->detail;
    }

    /**
     * 割増の適用可否を返す
     * @return bool
     */
    public function applicable(): bool
    {
        // 休日かどうか（ここでは判定していない）
        $isHoliday = true;
        return $isHoliday && ($this->ExtraChargeDetail[self::KEY] ?? 0) === 1;
    }
}