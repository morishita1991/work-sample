## チケット料金計算プログラム(Windows推奨 ※macOSでの動作未確認)

## 要件
- 団体割引は1回の決済で扱うチケットのみを対象とする。
- 特定の曜日・時間帯に伴う割引/割増料金は手動での指定とする。
- チケットから読み取れる情報は[タイプ(種別)]と[年齢区分]のみとする。

| タイプ | 大人 | 子供 | シニア |
| ------ | ---- | ---- | ----- |
|  通常  |  1000 | 500 | 800 |
|  特別  |  600  | 400 | 500 |

- 以下の条件のときに料⾦を変動させる。(特別タイプのチケットでも同様の条件
で料⾦変動させる)
    - 団体割引 10⼈以上だと10%割引(⼦供は0.5⼈換算とする)
    - ⼣⽅料⾦ ⼣⽅17時以降は100円引きとする。
    - 休⽇料⾦ 休⽇は200円増とする。
    - ⽉⽔割引 ⽉曜と⽔曜は100円引きとする。

- 発⽣しうるエラーパターンについても⼗分考慮して適切に制御すること。
- オペレータはPCのターミナルより該当プログラムの実⾏をする。
- 出⼒結果には、最低限以下を表⽰すること。
    - 販売合計⾦額
    - ⾦額変更前合計⾦額
    - ⾦額変更明細

 
## 料金計算の流れ
- 実行コマンド
```
php .\src\Casher.php
```

### 1. チケットの登録
- チケットの種別を半角数字で入力してください。通常「1」, 特別「2」 : 
- チケットの年齢区分を半角数字で入力してください。大人「1」, 子供「2」, シニア「3」 : 
- チケットの枚数を半角数字で入力してください: 例「3」
- 現在、以下の内容が登録されています。
```
例: 通常チケット: 大人 2枚
    通常チケット: 子供 2枚
    特別チケット: シニア 1枚
```
- ほかにチケットを登録しますか？ はい「1」, いいえ「2」, 最初からやり直す「3」 : 

 
### 2. 割引/割増対象の指定
- 割引方法を入力してください。次へ進む「0」, 団体割引「1」, 夕方料金「2」, 月水割引「3」 : 
- 例: 団体割引を適用しました。
- 他に割引は必要ですか？ はい「1」, いいえ「2」 :

- 割増方法を入力してください。次へ進む「0」, 休日料金「1」 : 
- 例: 休日料金を適用しました。


### 3. 請求内容の確認
- 現在、以下の内容が登録されています。
```
例: 通常チケット: 大人 2枚
    通常チケット: 子供 2枚
    特別チケット: シニア 1枚
    割引対象: 「夕方料金」
    割増対象: 「休日料金」

    変更前合計金額: 3,500円

    金額変更明細 -------
        割引合計: -100円
        割増合計: +200円
    -------------------
    販売合計金額: 3,600円
```


-  上記の内容で請求を確定します。よろしいですか？ はい「1」, 最初からやり直す「2」 : 
-  決済が完了しました。


## テスト結果

### PHPUnit実行結果
- 実行コマンド
```
vendor/bin/phpunit test/ --do-not-cache-result
```

#### 48 tests, 96 assertions
```
PHPUnit 10.2.4 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.4

................................................                  48 / 48 (100%)

Time: 00:00.021, Memory: 8.00 MB

OK (48 tests, 96 assertions)
```

### テストケース一覧（入力値バリデーション）

| 項番 |          テスト対象         | 前提条件 |    操作    |         期待される挙動     | テスト結果 |
| ---- | -------------------------- | -------- | -------- | -------------------------- | -- |
| 01 | チケット種別の登録（成功例-1）  | なし | '1'を入力 | '通常'として登録できること | OK |
| 02 | チケット種別の登録（成功例-2）  | なし | '2'を入力 | '特別'として登録できること | OK |
| 03 | チケット種別の登録（失敗例-1）  | なし | '0'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 04 | チケット種別の登録（失敗例-2）  | なし | '3'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 05 | チケット種別の登録（失敗例-3）  | なし | '１'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 06 | チケット種別の登録（失敗例-4）  | なし | 'いち'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 07 | チケット年齢区分の登録（成功例-1）  | なし | '1'を入力 | '大人'として登録をできること | OK |
| 08 | チケット年齢区分の登録（成功例-2）  | なし | '2'を入力 | '子供'として登録をできること | OK |
| 09 | チケット年齢区分の登録（成功例-3）  | なし | '3'を入力 | 'シニア'として登録をできること | OK |
| 10 | チケット年齢区分の登録（失敗例-1）  | なし | '0'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 11 | チケット年齢区分の登録（失敗例-2）  | なし | '4'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 12 | チケット年齢区分の登録（失敗例-3）  | なし | '１'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 13 | チケット年齢区分の登録（失敗例-4）  | なし | 'いち'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 14 | チケット枚数の登録（成功例-1）  | なし | '1'を入力 | '1枚'として登録できること | OK |
| 15 | チケット枚数の登録（成功例-2）  | なし | '100'を入力 | '100枚'として登録できること | OK |
| 16 | チケット枚数の登録（成功例-3）  | なし | '1000'を入力 | '1000枚'として登録できること | OK |
| 17 | チケット枚数の登録（失敗例-1）  | なし | '0'を入力 | '1から1000までの半角数字で入力してください。'として登録を拒否されること | OK |
| 18 | チケット枚数の登録（失敗例-2）  | なし | '-1'を入力 | '1から1000までの半角数字で入力してください。'として登録を拒否されること | OK |
| 19 | チケット枚数の登録（失敗例-3）  | なし | '1001'を入力 | '1から1000までの半角数字で入力してください。'として登録を拒否されること | OK |
| 20 | チケット枚数の登録（失敗例-4）  | なし | '１'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 21 | チケット枚数の登録（失敗例-5）  | なし | 'いち'を入力 | '半角数字で入力してください。'として登録を拒否されること | OK |
| 22 | 割引方法の登録（成功例-1）  | なし | '0'を入力 | '次へ進む'として登録できること | OK |
| 23 | 割引方法の登録（成功例-2）  | 通常チケット: 大人10枚を登録済み | '1'を入力 | '団体割引'として登録できること | OK |
| 24 | 割引方法の登録（成功例-3）  | 通常チケット: 大人1枚, 特別チケット: 子供18枚(9人分)を登録済み | '1'を入力 | '団体割引'として登録できること | OK |
| 25 | 割引方法の登録（成功例-4）  | なし | '2'を入力 | '夕方料金'として登録できること | OK |
| 26 | 割引方法の登録（成功例-5）  | なし | '3'を入力 | '月水割引'として登録できること | OK |
| 27 | 割引方法の登録（失敗例-1）  | なし | '4'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 28 | 割引方法の登録（失敗例-2）  | なし | '100'を入力 | '指定外の数字は入力しないでください。'として登録を拒否されること | OK |
| 29 | 割引方法の登録（失敗例-3）  | 通常チケット: 大人1枚, 特別チケット: 子供2枚を登録済み | '1'を入力 | '10人未満は「団体割引」を適用できません。'として登録を拒否されること | OK |
| 30 | 割引方法の登録（失敗例-4）  | 通常チケット: 大人1枚, 特別チケット: 子供17枚(8.5人分)を登録済み | '1'を入力 | '10人未満は「団体割引」を適用できません。'として登録を拒否されること | OK |