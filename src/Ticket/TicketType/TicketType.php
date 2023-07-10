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

    /**
     * 入力値のバリデーション結果
     * @var array{result:false|int,error:string}
     */
    public array $validResult;

    public function listen()
    {
        $this->validate();
        if ($this->validResult['result'] === false) {
            $this->line($this->validResult['error']);
            $this->listen(); // もう一度
        } else {
            $this->type = $this->validResult['result'];
        }
    }

    /**
     * チケットの種別
     * 不正な値の場合は、エラーメッセージを返します。
     * @return void
     */
    public function validate()
    {
        $labelList = [];
        foreach(self::LIST as $key => $label) {
            $labelList[] = $label . '「' . strval($key) . '」';
        }
        $input = $this->ask('チケットの種別を半角数字で入力してください。' . implode(', ', $labelList) . ' : ');
        if (!is_numeric($input)) {
            $this->validResult = $this->inputError('半角数字で入力してください。');
            return;
        }
        $value = intval($input);
        if (!in_array($value, [1, 2], true)) {
            $this->validResult = $this->inputError('指定外の数字は入力しないでください。');
            return;
        }
        $this->validResult = $this->inputSuccess($value);
    }
}