<?php
include_once './src/Ticket/Ticket.php';
include_once './src/Ticket/Price/Discount/Discount.php';
include_once './src/Ticket/Price/ExtraCharge/ExtraCharge.php';

/**
 * Unitテストの実行
 * vendor/bin/phpunit test/ --do-not-cache-result
 * 
 * 要件
 * - 団体割引は1回の決済で扱うチケットのみを対象とする。
 * - 特定の曜日・時間帯に伴う割引/割増料金は手動での指定とする。
 * - チケットから読み取れる情報は[種別]と[年齢区分]のみとする。
 * 
 * 
 * 料金計算の流れ
 * 
 * 
 * 1. チケットの登録
 *  チケットの種別を半角数字で入力してください。通常「1」, 特別「2」 : 
 *  チケットの年齢区分を半角数字で入力してください。大人「1」, 子供「2」, シニア「3」 : 
 *  チケットの枚数を半角数字で入力してください: 例「3」
 *  現在、以下の内容が登録されています。
 *  例 通常チケット: 大人 6枚
 *     通常チケット: 子供 2枚
 *     特別チケット: シニア 3枚
 * 
 *  ほかにチケットを登録しますか？ はい「1」, いいえ「2」, 最初からやり直す「3」 : 
 * 
 * 
 * 2. 割引/割増対象の指定
 *  割引方法を入力してください。次へ進む「0」, 団体割引「1」, 夕方料金「2」, 月水割引「3」 : 
 *  例: 団体割引を適用しました。
 *  他に割引は必要ですか？ はい「1」, いいえ「2」 :
 * 
 *  割増方法を入力してください。次へ進む「0」, 休日料金「1」 : 
 *  例 休日料金を適用しました。
 * 
 * 
 * 3. 請求内容の確認
 *  現在、以下の内容が登録されています。
 * 例: 通常チケット: 大人 1枚
 *     割引対象: 「夕方料金」
 *     割増対象: 「休日料金」

 *    変更前合計金額: 1,000円

 *    金額変更明細 --------
 *         割引合計: -100円
 *         割増合計: +200円
 *    --------------------
 *    販売合計金額: 1,100円
 * 
 *  上記の内容で請求を確定します。よろしいですか？ はい「1」, 最初からやり直す「2」 : 
 *  決済が完了しました。
 * 
 */

(new Casher)->Execute();

class Casher
{
    public function Execute()
    {
        $ticket = new Ticket();
        $ticket->register($ticket);
        
        $discount = new Discount($ticket);
        $discount->listen();
        
        $extraCharge = new ExtraCharge();
        $extraCharge->listen();
        
        $ticket->confirm();
        $discount->confirm();
        $extraCharge->confirm();

        $price = new Price($ticket, $discount, $extraCharge);
        $price->confirm();
        $price->listen();
    }
}
