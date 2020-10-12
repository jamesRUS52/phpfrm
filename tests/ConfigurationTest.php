<?php

namespace jamesRUS52\phpfrm\Tests;

use jamesRUS52\phpfrm\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        define("ROOT", dirname(__DIR__));
        define("CONF", ROOT.'/config');
    }


    public function testgetInstance()
    {
        $conf = Configuration::getInstance();
        $this->assertInstanceOf(\jamesRUS52\phpfrm\Configuration::class, $conf);
    }

    public function getValue()
    {
        $conf = Configuration::getInstance();
        $param_value = $conf->getParam('app_name');
        $this->assertEquals("Тестовое приложение", $param_value);
    }
}
