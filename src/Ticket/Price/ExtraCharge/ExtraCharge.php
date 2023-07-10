<?php
include_once './src/CliApp.php';
include_once 'HolidayCharge.php';

class ExtraCharge extends CliApp
{
    public string $type;

    const LIST = [
        HolidayCharge::KEY => HolidayCharge::LABEL,
    ];

    public array $detail = [];

    /**
     * 入力値のバリデーション結果
     * @var array{result:false|int,error:string}
     */
    public array $validResult;

    public function listen()
    {
        $this->validate();

        $result = $this->validResult['result'];
        if ($result === false) {
            $this->line($this->validResult['error']);
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
            $this->line('割増対象: なし');
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
        $this->line('割増対象: ' . $line);
    }

    /**
     * 割増合計金額を返す
     * @return int
     */
    public function extraChargeAmount(): int
    {
        $amount = 0; // 割増合計
        if ((new HolidayCharge($this))->applicable()) {
            $amount += HolidayCharge::CHARGE_VALUE;
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
     * 割増種別の入力
     * 不正な値の場合は、エラーメッセージを返します。
     * @return void
     */
    public function validate()
    {
        $this->line('');
        $this->line('割増方法を入力してください。');
        $input = $this->ask($this->askMassage());
        $this->line('');
        if (!is_numeric($input)) {
            $this->validResult = $this->inputError('半角数字で入力してください。');
            return;
        }
        $value = intval($input);
        if (!in_array($value, array_merge(array_keys(self::LIST), [0]), true)) {
            $this->validResult = $this->inputError('指定外の数字は入力しないでください。');
            return;
        }
        $this->validResult = $this->inputSuccess($value);
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
     * 再び割増種別の入力を行うかどうか
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validateMore()
    {
        $input = $this->ask('他に割増は必要ですか？ はい「1」, いいえ「2」 : ');
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