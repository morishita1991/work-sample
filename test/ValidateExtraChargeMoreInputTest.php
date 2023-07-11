<?php
declare(strict_types=1);

include_once './src/Ticket/Ticket.php';
include_once './src/Ticket/Price/ExtraCharge/ExtraCharge.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateExtraChargeMoreInputTest extends TestCase
{
    /**
     * 割増対象の再入力バリデーション
     * --- 成功例: 入力値「'1'」-- はい
     */
    public function testValidateExtraChargeMoreInput_Success01()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertSame(intval($input), $extraCharge->validResultMore['result']);
        $this->assertSame('', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の再入力バリデーション
     * --- 成功例: 入力値「'2'」-- いいえ
     */
    public function testValidateExtraChargeMoreInput_Success02()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertSame(intval($input), $extraCharge->validResultMore['result']);
        $this->assertSame('', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の再入力バリデーション
     * --- 失敗例: 入力値「'0'」
     */
    public function testValidateExtraChargeMoreInput_Error01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertFalse($extraCharge->validResultMore['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の再入力バリデーション
     * --- 失敗例: 入力値「'3'」
     */
    public function testValidateExtraChargeMoreInput_Error02()
    {
        $input = '3';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertFalse($extraCharge->validResultMore['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の再入力バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateExtraChargeMoreInput_Error03()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertFalse($extraCharge->validResultMore['result']);
        $this->assertSame('半角数字で入力してください。', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の再入力バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateExtraChargeMoreInput_Error04()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $ticket = new Ticket();
        $extraCharge = new ExtraCharge($ticket);
        $extraCharge->validateMore();
        $this->assertFalse($extraCharge->validResultMore['result']);
        $this->assertSame('半角数字で入力してください。', $extraCharge->validResultMore['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}