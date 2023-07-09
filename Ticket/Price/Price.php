<?php
include_once './CliApp.php';
include_once './Ticket/Ticket.php';
include_once 'Discount/Discount.php';
include_once 'ExtraCharge/ExtraCharge.php';

class Price extends CliApp {

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

    // 金額変更前合計金額
    public int $PreTotalAmount = 0;

    // 販売合計金額
    private int $TotalAmount = 0;

    private array $ticketDetail;
    private array $discountDetail;
    private array $extraChargeDetail;

    public function __construct(
        Ticket $ticket,
        Discount $discount,
        ExtraCharge $extraCharge,
    )
    {
        $this->ticketDetail = $ticket->detail;
        $this->discountDetail = $discount->detail;
        $this->extraChargeDetail = $extraCharge->detail;
        $this->Calculate();
    }

    public function listen()
    {
    }

    public function confirm()
    {
        $this->line('割引対象: ' . number_format($this->PreTotalAmount) . '円');
        $this->line('');
    }

    private function Calculate()
    {
        // 金額変更前合計金額
        $this->calcPreTotalAmount();
        // 合計販売金額
        $this->calcTotalAmount();
    }

    private function calcPreTotalAmount()
    {
        foreach($this->ticketDetail as $type => $arr) {
            foreach ($arr as $category => $quantity) {
                $this->PreTotalAmount += self::UNIT_PRICE[$type][$category] * $quantity;
            }
        }
    }

    private function calcTotalAmount()
    {
        return $this->PreTotalAmount + $this->getOptionalCharge();
    }

    private function getOptionalCharge()
    {
        // TODO: getDiscountの戻り値は負の値
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

