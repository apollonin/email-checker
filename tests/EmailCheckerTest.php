<?php

namespace Tests;

use Seredenko\ConfigProviders\ArrayConfigProvider;
use Seredenko\ConfigProviders\JsonConfigProvider;
use Seredenko\EmailChecker;
use Seredenko\Exceptions\BadConfigException;
use Seredenko\Exceptions\EmptyEmailException;

class EmailCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmailChecker
     */
    private $checker;

    public function setUp()
    {
        $this->checker = new EmailChecker(new JsonConfigProvider());
    }

    public function testEmptyEmail()
    {
        $this->expectException(EmptyEmailException::class);
        $this->checker->verify('');
    }

    public function testBadConfig()
    {
        $this->expectException(BadConfigException::class);
        $this->checker = new EmailChecker(new ArrayConfigProvider(['test' => false]));
        $this->checker->verify('test@mail.ru');
    }

    public function testValidEmail()
    {
        $result = $this->checker->verify('test@mail.ru');
        $this->assertEquals($result['result'], 'valid');
    }

    public function testInvalidEmail()
    {
        $result = $this->checker->verify($this->generateRandomString(10) . '@' . $this->generateRandomString(10) . '.ru');
        $this->assertEquals($result['result'], 'invalid');
    }

    public function testDisposableEmail()
    {
        $result = $this->checker->verify('test@mailinator.com');
        $this->assertEquals($result['result'], 'invalid');
    }

    public function testDisposableEmailWithAllowDisposable()
    {
        $result = $this->checker->verify('test@mailinator.com', true);
        $this->assertEquals($result['result'], 'valid');
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[ rand(0, $charactersLength - 1) ];
        }

        return $randomString;
    }
}
