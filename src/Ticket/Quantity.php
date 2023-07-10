<?php
include_once './src/CliApp.php';

class Quantity extends CliApp
{
    public int $quantity;

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
            $this->quantity = $result;
        }
    }

    /**
     * チケットの枚数
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('チケットの枚数を半角数字で入力してください : ');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if ($value < 1 || 1000 < $value) {
            return $this->inputError('1から1000までの半角数字で入力してください。');
        }
        return $this->inputSuccess($value);
    }
}