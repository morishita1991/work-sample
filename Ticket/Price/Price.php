<?php

class Price {
    private const UNIT_PRICE = [
        // 通常
        Normal::KEY => [
            // 大人
            Adult::KEY => 1000,
            // 子供
            Child::KEY => 500,
            // シニア
            Senior::KEY => 800
        ],
        // 特別
        Special::KEY => [
            // 大人
            Adult::KEY => 600,
            // 子供
            Child::KEY => 400,
            // シニア
            Senior::KEY => 500
        ]
    ];

    public function __construct()
    {
        $this->setUnitPrice();
    }

    private function setUnitPrice()
    {
        $typeList = TicketType::LIST;
        $ageCategoryList = AgeCategory::LIST;
        $unitPriceList = [];
        foreach ($typeList as $type) {
            switch($type) {
                case 1:
                    // 通常
                    break;
                case 2:
                    // 特別
                    break;
            }
        }
    }

    // public function Execute()
    // {
    //     // 金額変更前合計金額
    //     $this->calcPreTotalAmount();
    //     // 合計販売金額
    //     $this->calcTotalAmount();
    //     return  + $this->ExtraCharge - $this->Discount;
    // }

    // private function calcPreTotalAmount()
    // {
    //     $this->PreTotalAmount = self::BASE_CHARGE[$this->Type][$this->AgeCategory] * $this->NumberOfTickets;
    // }

    // private function calcTotalAmount()
    // {
    //     return $this->PreTotalAmount + $this->getOptionalCharge();
    // }

    // private function getOptionalCharge()
    // {
    //     // TODO: getDiscountの戻り値は0以下の値である
    //     return $this->getExtraCharge() + $this->getDiscount();
    // }

    // private function getDiscount()
    // {
    //     return [
    //         // ドメインを吸収
    //         'bulk' => $this->getBulkDiscount(),
    //         'evening' => $this->getEveningDiscount(),
    //     ][$this->Discount];
    // }

    // private function getBulkDiscount()
    // {
    //     // 10人以上だと10%割引(子供は0.5人換算とする)
    //     $discountRate = 0.1;
    //     return $this->PreTotalAmount * $discountRate * (-1);
    // }

    // private function getEveningDiscount()
    // {

    // }
}

