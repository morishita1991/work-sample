<?php
declare(strict_types=1);

include_once './src/Ticket/TicketType/TicketType.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateTicketTypeInputTest extends TestCase
{
    /**
     * チケット種別の入力値バリデーション
     * --- 成功例: 入力値「'1'」-- 通常
     */
    public function testValidateTicketTypeInput_Success01()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertSame(intval($input), $ticketType->validResult['result']);
        $this->assertSame('', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット種別の入力値バリデーション
     * --- 成功例: 入力値「'2'」-- 特別
     */
    public function testValidateTicketTypeInput_Success02()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertSame(intval($input), $ticketType->validResult['result']);
        $this->assertSame('', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット種別の入力値バリデーション
     * --- 失敗例: 入力値「'0'」
     */
    public function testValidateTicketTypeInput_Error01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertFalse($ticketType->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット種別の入力値バリデーション
     * --- 失敗例: 入力値「'3'」
     */
    public function testValidateTicketTypeInput_Error02()
    {
        $input = '3';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertFalse($ticketType->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット種別の入力値バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateTicketTypeInput_Error03()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertFalse($ticketType->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット種別の入力値バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateTicketTypeInput_Error04()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $ticketType = new TicketType();
        $ticketType->validate();
        $this->assertFalse($ticketType->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $ticketType->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}