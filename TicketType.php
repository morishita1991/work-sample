<?php
include_once './CliApp.php';

/**
 * アプリケーション本体
 *
 * Appクラスを「継承」して、アプリケーションに必要なロジックをここに記述します。
 */
class TicketType extends CliApp
{
    public string $type;

    const TYPE_LIST = [
        1 => '通常',
        2 => '特別',
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
            $this->type = self::TYPE_LIST[$result];
        }
    }

    /**
     * チケットの種別
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('チケットの種別を半角数字で入力してください。通常「1」, 特別「2」 : ');
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