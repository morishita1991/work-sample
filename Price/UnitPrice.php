<?php

class UnitPrice {
    private const UNIT_PRICE = [
        [
            // 通常
            'ticketType' => 1,
            'unitPrice' => [
                [
                    // 大人
                    'ageCategory' => 1,
                    'unitPrice' => 1000
                ],
                [
                    // 子供
                    'ageCategory' => 2,
                    'unitPrice' => 500
                ],
                [
                    // シニア
                    'ageCategory' => 3,
                    'unitPrice' => 800
                ],
            ]
        ],
        [
            // 特別
            'ticketType' => 2,
            'unitPrice' => [
                [
                    // 大人
                    'ageCategory' => 1,
                    'unitPrice' => 600
                ],
                [
                    // 子供
                    'ageCategory' => 2,
                    'unitPrice' => 400
                ],
                [
                    // シニア
                    'ageCategory' => 3,
                    'unitPrice' => 500
                ],
            ]
        ],
    ];

    public function __construct()
    {
        $this->setUnitPrice();
    }

    private function setUnitPrice()
    {
        $typeList = TicketType::LIST;
        $ageCategoryList = AgeCategory::CATEGORY_LIST;
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

