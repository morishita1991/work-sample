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

    private int $DiscountAmount = 0;

    private int $ExtraChargeAmount = 0;

    private Ticket $ticket;
    private Discount $discount;
    private ExtraCharge $extraCharge;

    public function __construct(
        Ticket $ticket,
        Discount $discount,
        ExtraCharge $extraCharge,
    )
    {
        $this->ticket = $ticket;
        $this->discount = $discount;
        $this->extraCharge = $extraCharge;
    }

    public function listen()
    {
        [
            'result' => $result,
            'error' => $error
        ] = $this->validate();

        if ($result === false) {
            $this->line($error);
            $this->listen();
        }
        if ($result === 1) {
            $this->line('決済が完了しました。');
            return;
        }
        if ($result === 2) {
            // 最初から
            (new Casher)->Execute();
        }
    }

    public function Calculate()
    {
        // 金額変更前合計金額
        $this->calcPreTotalAmount();
        $this->line('');
        $this->line('変更前合計金額: ' . number_format($this->PreTotalAmount) . '円');
        $this->line('');
        // 合計販売金額
        $this->calcTotalAmount();
        $this->line('金額変更明細 -------');
        $mark1 = $this->DiscountAmount !== 0 ? '-' : '';
        $mark2 = $this->ExtraChargeAmount !== 0 ? '+' : '';
        $this->line('    割引合計: ' . $mark1 . number_format($this->DiscountAmount) . '円');
        $this->line('    割増合計: ' . $mark2 . number_format($this->ExtraChargeAmount) . '円');
        $this->line('--------------------');
        $this->line('販売合計金額: ' . number_format($this->TotalAmount) . '円');
        $this->line('');
    }

    /**
     * 請求内容の確認
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('上記の内容で請求を確定します。よろしいですか？ はい「1」, 最初からやり直す「2」 : ');
        $this->line('');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, [1, 2], true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        return $this->inputSuccess($value);
    }

    private function calcPreTotalAmount()
    {
        foreach($this->ticket->detail as $type => $arr) {
            foreach ($arr as $category => $quantity) {
                $this->PreTotalAmount += self::UNIT_PRICE[$type][$category] * $quantity;
            }
        }
    }

    private function calcTotalAmount()
    {
        $this->DiscountAmount = $this->discount->discountAmount($this->ticket, $this);
        $this->ExtraChargeAmount = $this->extraCharge->extraChargeAmount();
        $this->TotalAmount = $this->PreTotalAmount - $this->DiscountAmount + $this->ExtraChargeAmount;
    }
}

