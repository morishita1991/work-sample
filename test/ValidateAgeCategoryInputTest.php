<?php
declare(strict_types=1);

include_once './src/Ticket/AgeCategory/AgeCategory.php';
use PHPUnit\Framework\TestCase;
$_SESSION['is_unittest'] = true;

class ValidateAgeCategoryInputTest extends TestCase
{
    /**
     * 年齢区分の入力値バリデーション
     * --- 成功例: 入力値「'1'」-- 大人
     */
    public function testValidateAgeCategoryInput_Success01()
    {
        $input = '1';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertSame(intval($input), $ageCategory->validResult['result']);
        $this->assertSame('', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 成功例: 入力値「'2'」-- 子供
     */
    public function testValidateAgeCategoryInput_Success02()
    {
        $input = '2';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertSame(intval($input), $ageCategory->validResult['result']);
        $this->assertSame('', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 成功例: 入力値「'3'」-- シニア
     */
    public function testValidateAgeCategoryInput_Success03()
    {
        $input = '3';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertSame(intval($input), $ageCategory->validResult['result']);
        $this->assertSame('', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 失敗例: 入力値「'0'」
     */
    public function testValidateAgeCategoryInput_Error01()
    {
        $input = '0';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertFalse($ageCategory->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 失敗例: 入力値「'4'」
     */
    public function testValidateAgeCategoryInput_Error02()
    {
        $input = '4';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertFalse($ageCategory->validResult['result']);
        $this->assertSame('指定外の数字は入力しないでください。', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 失敗例: 入力値「'１'」
     */
    public function testValidateAgeCategoryInput_Error03()
    {
        $input = '１';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertFalse($ageCategory->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }

    /**
     * 年齢区分の入力値バリデーション
     * --- 失敗例: 入力値「'いち'」
     */
    public function testValidateAgeCategoryInput_Error04()
    {
        $input = 'いち';
        $_SESSION['unittest_ask_input'] = $input;
        $ageCategory = new AgeCategory();
        $ageCategory->validate();
        $this->assertFalse($ageCategory->validResult['result']);
        $this->assertSame('半角数字で入力してください。', $ageCategory->validResult['error']);
        unset($_SESSION['unittest_ask_input']);
    }
}