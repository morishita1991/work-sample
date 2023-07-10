<?php
include_once './src/CliApp.php';
include_once 'NormalTicket.php';
include_once 'SpecialTicket.php';


class TicketType extends CliApp
{
    public int $type;

    public const LIST = [
        NormalTicket::KEY => NormalTicket::LABEL,
        SpecialTicket::KEY => SpecialTicket::LABEL,
    ];

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