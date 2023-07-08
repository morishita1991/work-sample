<?php
include_once './CliApp.php';

/**
 * アプリケーション本体
 *
 * Appクラスを「継承」して、アプリケーションに必要なロジックをここに記述します。
 */
class AgeCategory extends CliApp
{
    public string $category;

    const CATEGORY_LIST = [
        1 => '大人',
        2 => '子供',
        3 => 'シニア',
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
            $this->category = self::CATEGORY_LIST[$result];
        }
    }

    /**
     * 年齢区分
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('チケットの年齢区分を半角数字で入力してください。大人:「1」, 子供「2」, シニア「3」');
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