<?php
include_once './CliApp.php';
include_once 'Normal.php';
include_once 'Special.php';


class TicketType extends CliApp
{
    public int $type;

    public const LIST = [
        Normal::TYPE => Normal::LABEL,
        Special::TYPE => Special::LABEL,
    ];

    /**
     * アプリケーション実行メソッド
     * アプリケーション独自の処理を記述する
     *
     * @return void
     */
    public function listen()
    {
        [
            'result' => $result,
            'error' => $error
        ] = $this->validate();

        if ($result === false) {
            $this->line($error);
            $this->listen(); // もう一度
        } else {
            $this->type = $result;
        }
    }

    /**
     * チケットの種別
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $labelList = [];
        foreach(self::LIST as $key => $label) {
            $labelList[] = $label . '「' . strval($key) . '」';
        }
        $input = $this->ask('チケットの種別を半角数字で入力してください。' . implode(', ', $labelList) . ' : ');
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