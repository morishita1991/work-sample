<?php
/**
 * アプリケーションのベースとなる「抽象クラス」
 * メッセージ表示・入力受付などの基本的なメソッドが用意されています。
 */
abstract class App
{
    /**
     * アプリケーション実行メソッド
     * 「抽象メソッド」です。「継承」したクラスで、このメソッドを定義しないとエラーになります。
     *
     * @return void
     */
    abstract public function execute();


    /*
    |--------------------------------------------------------------------------
    | 以下、汎用的な「メソッド」を定義
    |--------------------------------------------------------------------------
    |
    */

    /**
     * 画面に文字を表示：末尾に改行なし
     *
     * @param string $message
     */
    protected function message(string $message)
    {
        // 危険な文字はエスケープする（HTMLエスケープのシェル版みたいなもの）
        echo escapeshellcmd($message);
    }

    /**
     * 画面に文字を表示：末尾に改行あり
     *
     * @param string $message
     */
    protected function line(string $message)
    {
        echo escapeshellcmd($message) . "\n";
    }

    /**
     * 画面に文字を表示して、入力を受け付ける
     *
     * @param string $message
     * @return string
     */
    protected function ask(string $message)
    {
        // メッセージを表示し、「標準入力」の受け付け待ち。
        // 前後のスペースなど、入力ミスと思われるものを除外（trim）してあげるのは優しさ。
        $this->message($message);
        return trim(fgets(STDIN));
    }

}