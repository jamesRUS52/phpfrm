<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author james
 */

namespace jamesRUS52\phpfrm;

class App {
    //put your code here
    /**
     *
     * @var Configuration
     */
    public static $config;
    public function __construct() {
        session_start();
       
        $query = trim($_SERVER['QUERY_STRING'],'/');

        self::$config = Configuration::getInstance();
        
//        $log = Log::getInstance();
//        $log->info("run");
//        $log->warning("two");
//        $log->error("error");


        
        new ErrorHandler();
        
        Router::dispatch($query);

    }

}
