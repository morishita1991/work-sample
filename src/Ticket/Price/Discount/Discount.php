<?php
include_once './src/CliApp.php';
include_once './src/Ticket/Price/Price.php';
include_once 'BulkDiscount.php';
include_once 'EveningDiscount.php';
include_once 'MondayWednesDayDiscount.php';

class Discount extends CliApp
{
    public string $type;

    const LIST = [
        BulkDiscount::KEY => BulkDiscount::LABEL,
        EveningDiscount::KEY => EveningDiscount::LABEL,
        MondayWednesDayDiscount::KEY => MondayWednesDayDiscount::LABEL
    ];

    private Ticket $ticket;

    public array $detail = [];

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
            return;
        }
        if ($result === 0) {
            return;
        }
        $this->line(self::LIST[$result] . 'を適用しました。');
        $this->line('');

        // 適用した割引
        $this->detail[$result] = 1;
        if (count($this->detail) === count(self::LIST)) {
            return;
        }
        $this->listenMore();
    }

    public function confirm()
    {
        if (empty($this->detail)) {
            $this->line('割引対象: なし');
            return;
        }
        $discountList = [];
        foreach(array_keys($this->detail) as $type) {
            $discountList[] = '「' . self::LIST[$type] . '」';
        }
        $line = 'なし';
        if (!empty($discountList)) {
            $line = implode(',', $discountList);
        }
        $this->line('割引対象: ' . $line);
    }

    /**
     * 割引合計金額を返す
     * @param Ticket $ticket
     * @param Price $price
     * @return int
     */
    public function discountAmount(Ticket $ticket, Price $price): int
    {
        $amount = 0; // 割引合計
        if ((new BulkDiscount($this, $ticket))->applicable()) {
            $amount += intval($price->PreTotalAmount * BulkDiscount::DISCOUNT_RATE / 100);
        }
        if ((new EveningDiscount($this))->applicable()) {
            $amount += EveningDiscount::DISCOUNT_VALUE;
        }
        if ((new MondayWednesDayDiscount($this))->applicable()) {
            $amount += EveningDiscount::DISCOUNT_VALUE;
        }
        return $amount;
    }

    private function listenMore()
    {
        [
            'result' => $result,
            'error' => $error
        ] = $this->validateMore();

        if ($result === false) {
            $this->line($error);
            $this->listenMore();
            return;
        }
        if ($result === 1) {
            $this->listen();
        }
        if ($result === 2) {
            return;
        }
    }

    /**
     * 割引種別の入力
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $this->line('');
        $this->line('割引方法を入力してください。');
        $input = $this->ask($this->askMassage());
        $this->line('');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, array_merge(array_keys(self::LIST), [0]), true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        if ($value === BulkDiscount::KEY && !(new BulkDiscount($this, $this->ticket))->isOver10Tickets()) {
            return $this->inputError('10人未満は「団体割引」を適用できません。');
        }
        return $this->inputSuccess($value);
    }

    private function askMassage()
    {
        $askList = ['次へ進む「0」'];
        foreach (self::LIST as $key => $val) {
            if (!in_array($key, array_keys($this->detail), true)) {
                $askList[] = $val . '「' . strval($key) . '」';
            }
        }
        $message = implode(', ' , $askList);
        return $message . ' : ';
    }

    /**
     * 再び割引種別の入力を行うかどうか
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validateMore()
    {
        $input = $this->ask('他に割引は必要ですか？ はい「1」, いいえ「2」 : ');
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
}