<?php
declare(strict_types=1);

include_once './src/Ticket/Ticket.php';
include_once './src/Ticket/AgeCategory/Child.php';
include_once './src/Ticket/AgeCategory/Adult.php';
include_once './src/Ticket/TicketType/SpecialTicket.php';
include_once './src/Ticket/TicketType/NormalTicket.php';
include_once './src/Ticket/Price/Discount/Discount.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateDiscountInputTest extends TestCase
{
    /**
     * 割引対象の入力値バリデーション
     * --- 成功例: 入力値「'0'」-- 次へ進む
     */
    public function testValidateDiscountInput_Success01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $discount = new Discount(new Ticket);
        $discount->validate();
        $this->assertSame(intval($input), $discount->validResult['result']);
        $this->assertSame('', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 成功例: 入力値「'1'」＆チケット10枚 -> 「団体割引」適用可。
     */
    public function testValidateDiscountInput_Success02()
    {
        $input = '1'; // 団体割引
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $ticket->detail = [
            // 通常チケット: 大人10枚を登録しておく
            NormalTicket::KEY => [
                Adult::KEY => 10
            ]
        ];
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertSame(intval($input), $discount->validResult['result']);
        $this->assertSame('', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 成功例: 入力値「'1'」＆チケット10枚 -> 「団体割引」適用可。
     */
    public function testValidateDiscountInput_Success03()
    {
        $input = '1'; // 団体割引
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $ticket->detail = [
            // 通常チケット: 大人1枚, 特別チケット: 子供18枚(9人分)を登録
            NormalTicket::KEY => [
                Adult::KEY => 1
            ],
            SpecialTicket::KEY => [
                Child::KEY => 18
            ]
        ];
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertSame(intval($input), $discount->validResult['result']);
        $this->assertSame('', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 成功例: 入力値「'2'」-- 夕方料金
     */
    public function testValidateDiscountInput_Success04()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertSame(intval($input), $discount->validResult['result']);
        $this->assertSame('', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 成功例: 入力値「'3'」-- 月水割引
     */
    public function testValidateDiscountInput_Success05()
    {
        $input = '3';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertSame(intval($input), $discount->validResult['result']);
        $this->assertSame('', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 失敗例: 入力値「'4'」
     */
    public function testValidateDiscountInput_Error01()
    {
        $input = '4';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertFalse($discount->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 失敗例: 入力値「'100'」
     */
    public function testValidateDiscountInput_Error02()
    {
        $input = '100';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertFalse($discount->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 失敗例: 入力値「'1'」＆チケット10枚未満 -> 「団体割引」適用不可。
     */
    public function testValidateDiscountInput_Error03()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $ticket->detail = [
            // 通常チケット: 大人1枚, 特別チケット: 子供2枚を登録
            NormalTicket::KEY => [
                Adult::KEY => 1
            ],
            SpecialTicket::KEY => [
                Child::KEY => 2
            ]
        ];
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertFalse($discount->validResult['result']);
        $this->assertSame('10人未満は「団体割引」を適用できません。', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の入力値バリデーション
     * --- 失敗例: 入力値「'1'」＆チケット10枚未満 -> 「団体割引」適用不可。
     */
    public function testValidateDiscountInput_Error04()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $ticket->detail = [
            // 通常チケット: 大人1枚, 特別チケット: 子供17枚(8.5人分)を登録
            NormalTicket::KEY => [
                Adult::KEY => 1
            ],
            SpecialTicket::KEY => [
                Child::KEY => 17
            ]
        ];
        $discount = new Discount($ticket);
        $discount->validate();
        $this->assertFalse($discount->validResult['result']);
        $this->assertSame('10人未満は「団体割引」を適用できません。', $discount->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}