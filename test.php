<?php
/**
 * 動物園のチケット販売オペレーター⽤⾦額計算プログラム
 */


class Calc {
    // 外部入力
    private string $Type;
    private string $AgeCategory;
    private int $NumberOfTickets;
    private string $Discount;
    private string $ExtraCharge;

    private int $PreTotalAmount;

    private const BASE_CHARGE = [
        'normal' => [
            'adult' => 1000,
            'child' => 500,
            'senior' => 800,
        ],
        'special' => [
            'adult' => 600,
            'child' => 400,
            'senior' => 500,
        ],
    ];

    public function __construct($params = [])
    {
        // TODO: バリデーション
        $this->Type = $params['type'];
        $this->AgeCategory = $params['ageCategory'];
        $this->NumberOfTickets = $params['numberOfTickets'];
        $this->Discount = $params['discount'];
        $this->ExtraCharge = $params['extraCharge'];
    }

    public function Execute()
    {
        // 金額変更前合計金額
        $this->calcPreTotalAmount();
        // 合計販売金額
        $this->calcTotalAmount();
        return  + $this->ExtraCharge - $this->Discount;
    }

    private function calcPreTotalAmount()
    {
        $this->PreTotalAmount = self::BASE_CHARGE[$this->Type][$this->AgeCategory] * $this->NumberOfTickets;
    }

    private function calcTotalAmount()
    {
        return $this->PreTotalAmount + $this->getOptionalCharge();
    }

    private function getOptionalCharge()
    {
        // TODO: getDiscountの戻り値は0以下の値である
        return $this->getExtraCharge() + $this->getDiscount();
    }

    private function getDiscount()
    {
        return [
            // ドメインを吸収
            'bulk' => $this->getBulkDiscount(),
            'evening' => $this->getEveningDiscount(),
        ][$this->Discount];
    }

    private function getBulkDiscount()
    {
        // 10人以上だと10%割引(子供は0.5人換算とする)
        $discountRate = 0.1;
        return $this->PreTotalAmount * $discountRate * (-1);
    }

    private function getEveningDiscount()
    {

    }
}

