<?php
include_once './src/CliApp.php';
include_once 'Adult.php';
include_once 'Child.php';
include_once 'Senior.php';


/**
 * アプリケーション本体
 *
 * Appクラスを「継承」して、アプリケーションに必要なロジックをここに記述します。
 */
class AgeCategory extends CliApp
{
    public string $category;

    public const LIST = [
        Adult::KEY => Adult::LABEL,
        Child::KEY => Child::LABEL,
        Senior::KEY => Senior::LABEL,
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
            $this->category = $result;
        }
    }

    /**
     * 年齢区分
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('チケットの年齢区分を半角数字で入力してください。大人「1」, 子供「2」, シニア「3」 : ');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, [1, 2, 3], true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        return $this->inputSuccess($value);
    }
}