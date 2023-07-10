<?php
include_once './src/CliApp.php';

class Quantity extends CliApp
{
    public int $quantity;

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
            $this->quantity = $this->validResult['result'];
        }
    }

    /**
     * チケットの枚数
     * 不正な値の場合は、エラーメッセージを返します。
     * @return void
     */
    public function validate()
    {
        $input = $this->ask('チケットの枚数を半角数字で入力してください : ');
        if (!is_numeric($input)) {
            $this->validResult = $this->inputError('半角数字で入力してください。');
            return;
        }
        $value = intval($input);
        if ($value < 1 || 1000 < $value) {
            $this->validResult = $this->inputError('1から1000までの半角数字で入力してください。');
            return;
        }
        $this->validResult = $this->inputSuccess($value);
    }
}