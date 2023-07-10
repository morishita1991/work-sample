<?php
include_once './Ticket/Ticket.php';
include_once './Ticket/Price/Discount/Discount.php';
include_once './Ticket/Price/ExtraCharge/ExtraCharge.php';

/**
 * 料金計算処理の呼び出し
 * 
 * ビジネス要件
 * - 団体割引は1回の決済で扱うチケットのみを対象とする。
 * - 特定の時間帯に伴う割引/割増料金は、
 * 
 * 
 * 制約条件
 * - チケットから読み取れる情報は[種別]と[年齢区分]のみとする
 * 
 * 
 * 料金計算の流れ：
 * 
 * 1. チケットの登録(最初に顧客が提示した全てのチケット情報を入力する)
 * 1-a. チケットの種別を半角数字で入力してください。通常:「1」, 特別:「2」
 * 1-b. 年齢区分を半角数字で入力してください。大人:「1」, 子供「2」, シニア「3」
 * 1-c. 枚数を半角数字で入力してください: 例「3」
 * 1-d2. 現在、以下の内容が登録されています。
 *  例 「通常」チケット「大人」 6枚
 *     「通常」チケット「子供」 2枚
 *     「特別」チケット「シニア」3枚
 * 
 * 1-e. ほかにチケットを登録しますか？ はい「1」, いいえ「2」 : 
 * 
 * 
 * 2. 割引/割増計算の指定
 * 2-a 適用する割引を入力してください。次へ進む「0」, 団体割引「1」, 夕方料金「2」, 月水割引「3」 : 
 * 2-b 団体割引を適用しました。
 * 
 * 2-d 適用する割増料金を入力してください。次へ進む「0」, 団体割引「1」, 夕方料金「2」, 月水割引「3」 : 
 * 2-e を適用しました。
 * 
 * 
 * 3. 請求内容の確認
 *  例 「通常」チケット「大人」 6枚
 *     「通常」チケット「子供」 2枚
 *   　「特別」チケット「シニア」3枚
 * 　　 割引対象:「団体割引」,「夕方料金」
 * 　　 割増対象: なし
 * 
 * 金額変更前合計金額: 
 * 金額変更明細:
 * 　　「団体割引」 - 円
 * 　　「夕方料金」 - 円
 * 
 * 販売合計金額: 100,000円
 * 
 * 上記の内容で請求を確定します。よろしければ「はい」を入力してください。
 * ※登録内容を破棄して最初からやり直す場合は「最初からやり直す」を入力してください。
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
