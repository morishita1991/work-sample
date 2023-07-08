<?php
include_once './CliApp.php';


class Discount extends CliApp
{
    public string $type;

    const TYPE_LIST = [
        1 => '団体割引',
        2 => '夕方料金',
        3 => '月水割引'
    ];

    private array $detail = [];

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
        $this->line(self::TYPE_LIST[$result] . 'を適用しました。');
        $this->line('');

        // 適用した割引
        $this->detail[$result] = 1;
        if (count($this->detail) === count(self::TYPE_LIST)) {
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
            $discountList[] = '「' . self::TYPE_LIST[$type] . '」';
        }
        $line = 'なし';
        if (!empty($discountList)) {
            $line = implode(',', $discountList);
        }
        $this->line('割引対象: ' . $line);
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
        $this->line('割引方法を入力してください。※次へ進む場合は「0」');
        $input = $this->ask($this->askMassage());
        $this->line('');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, array_merge(array_keys(self::TYPE_LIST), [0]), true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        return $this->inputSuccess($value);
    }

    private function askMassage()
    {
        $askList = [];
        foreach (self::TYPE_LIST as $key => $val) {
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