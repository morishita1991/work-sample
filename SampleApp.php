<?php
include_once './App.php';

/**
 * アプリケーション本体
 *
 * Appクラスを「継承」して、アプリケーションに必要なロジックをここに記述します。
 */
class SampleApp extends App
{
    /**
     * アプリケーション実行メソッド
     * アプリケーション独自の処理を記述する
     *
     * @return void
     */
    public function execute()
    {
        // 年齢を聞く
        $age = $this->listen();
        // 年齢として正しくない値が返ってきたら、メッセージを出力して終了する。
        if (false === $age) {
            $this->line('年齢を入力して！！');
            return;
        }
        // 大人かどうかで処理わけ
        if ($this->isAdult($age)) {
            $this->line('あなたは大人です。');
        } else {
            $this->line('お子ちゃまですね。');
            $this->line('早く寝なさい！！');
        }
    }

    /**
     * 年齢を聞きます
     * 年齢としておかしい値の場合はfalseを返します。
     *
     * @return false|int
     */
    protected function listen()
    {
        $input = $this->ask('年齢を入力してください：');

        // 優しさ。もし全角数値が入力されたら、半角数値に変換してあげる。
        $value = mb_convert_kana($input, 'n');

        // 年齢として扱えない：数値として扱えない文字列
        if (!is_numeric($value)) {
            return false;
        }
        // is_numeric()は、小数とかも許容してしまう。「キャスト」して無理やり整数にする。
        // 正確にやるなら、「正規表現」を使いますが、理解が難しいと思うのでここでは手抜き。
        $age = (int)$value;
        if (200 < $age) {
            // 200歳より大きかったら人間じゃないよね・・ということでfalseを返す
            return false;
        }
        // 入力された年齢を返す。
        return $age;
    }

    /**
     * 大人（20歳以上）ならtrueを返す。
     *
     * @param int $age
     * @return bool
     */
    protected function isAdult(int $age)
    {
        return (20 <= $age);
    }

}