<?php
declare(strict_types=1);

include_once './src/Ticket/Quantity.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateQuantityInputTest extends TestCase
{
    /**
     * チケット枚数の入力値バリデーション
     * --- 成功例: 入力値「'1'」
     */
    public function testValidateQuantityInput_Success01()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertSame(intval($input), $quantity->validResult['result']);
        $this->assertSame('', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 成功例: 入力値「'100'」
     */
    public function testValidateQuantityInput_Success02()
    {
        $input = '100';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertSame(intval($input), $quantity->validResult['result']);
        $this->assertSame('', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 成功例: 入力値「'1000'」
     */
    public function testValidateQuantityInput_Success03()
    {
        $input = '1000';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertSame(intval($input), $quantity->validResult['result']);
        $this->assertSame('', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 失敗例: 入力値「'0'」
     */
    public function testValidateQuantityInput_Error01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertFalse($quantity->validResult['result']);
        $this->assertSame('1から1000までの半角数字で入力してください。', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 失敗例: 入力値「'-1'」
     */
    public function testValidateQuantityInput_Error02()
    {
        $input = '-1';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertFalse($quantity->validResult['result']);
        $this->assertSame('1から1000までの半角数字で入力してください。', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 失敗例: 入力値「'1001'」
     */
    public function testValidateQuantityInput_Error03()
    {
        $input = '1001';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertFalse($quantity->validResult['result']);
        $this->assertSame('1から1000までの半角数字で入力してください。', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateQuantityInput_Error04()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertFalse($quantity->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * チケット枚数の入力値バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateQuantityInput_Error05()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $quantity = new Quantity();
        $quantity->validate();
        $this->assertFalse($quantity->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $quantity->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}