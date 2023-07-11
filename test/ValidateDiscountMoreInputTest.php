<?php
declare(strict_types=1);

include_once './src/Ticket/Ticket.php';
include_once './src/Ticket/Price/Discount/Discount.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateDiscountMoreInputTest extends TestCase
{
    /**
     * 割引対象の再入力バリデーション
     * --- 成功例: 入力値「'1'」-- はい
     */
    public function testValidateDiscountMoreInput_Success01()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertSame(intval($input), $discount->validResultMore['result']);
        $this->assertSame('', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の再入力バリデーション
     * --- 成功例: 入力値「'2'」-- いいえ
     */
    public function testValidateDiscountMoreInput_Success02()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertSame(intval($input), $discount->validResultMore['result']);
        $this->assertSame('', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の再入力バリデーション
     * --- 失敗例: 入力値「'0'」
     */
    public function testValidateDiscountMoreInput_Error01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertFalse($discount->validResultMore['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の再入力バリデーション
     * --- 失敗例: 入力値「'3'」
     */
    public function testValidateDiscountMoreInput_Error02()
    {
        $input = '3';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertFalse($discount->validResultMore['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の再入力バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateDiscountMoreInput_Error03()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertFalse($discount->validResultMore['result']);
        $this->assertSame('半角数字で入力してください。', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割引対象の再入力バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateDiscountMoreInput_Error04()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $discount = new Discount($ticket);
        $discount->validateMore();
        $this->assertFalse($discount->validResultMore['result']);
        $this->assertSame('半角数字で入力してください。', $discount->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}