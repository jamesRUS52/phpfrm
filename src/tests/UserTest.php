<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



namespace jamesRUS52\phpfrm\tests;

use \PHPUnit\Framework\TestCase;
use jamesRUS52\phpfrm\User;

/**
 * Description of UserTest
 *
 * @author james
 */
class UserTest extends TestCase{
    //put your code here
    public function testgetInstance()
    {
        $user = User::getInstance();
        $this->assertInstanceOf(\jamesRUS52\phpfrm\User::class, $user);
        
        $user2 = User::getInstance();
        $this->assertEquals($user, $user2);
        
    }
    
    public function testRoles()
    {
        $user = User::getInstance();
        $user->setRoles(["admin","superadmin"]);
        
        $superadmin = $user->hasRole("superadmin");
        $this->assertTrue($superadmin);
        
        $owner = $user->hasRole("owner");
        $this->assertFalse($owner);
    }
}
