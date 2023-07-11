<?php
declare(strict_types=1);

include_once './src/Ticket/Price/ExtraCharge/ExtraCharge.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateExtraChargeInputTest extends TestCase
{
    /**
     * 割増対象の入力値バリデーション
     * --- 成功例: 入力値「'0'」-- 次へ進む
     */
    public function testValidateExtraChargeInput_Success01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertSame(intval($input), $extraCharge->validResult['result']);
        $this->assertSame('', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の入力値バリデーション
     * --- 成功例: 入力値「'1'」-- 休日料金
     */
    public function testValidateExtraChargeInput_Success02()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertSame(intval($input), $extraCharge->validResult['result']);
        $this->assertSame('', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の入力値バリデーション
     * --- 失敗例: 入力値「'2'」
     */
    public function testValidateExtraChargeInput_Error01()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertFalse($extraCharge->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の入力値バリデーション
     * --- 失敗例: 入力値「'-1'」
     */
    public function testValidateExtraChargeInput_Error02()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertFalse($extraCharge->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の入力値バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateExtraChargeInput_Error03()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertFalse($extraCharge->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 割増対象の入力値バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateExtraChargeInput_Error04()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $extraCharge = new ExtraCharge();
        $extraCharge->validate();
        $this->assertFalse($extraCharge->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $extraCharge->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}