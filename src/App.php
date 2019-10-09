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
        
       new ErrorHandler();
        
       session_start();
       
       if (MAINTENANCE)
        {
            $ips = explode(",", MAINTENANCEIP );
            if (!in_array($_SERVER['REMOTE_ADDR'], $ips))
            {
                if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                {
                    header("HTTP/1.1 503 Service Unavailable");
                    print "Сервер на обслуживании. Попробуйте обновить страницу чуть позже";
                }
                else
                {
                    http_response_code(503);
                    require WWW.'/errors/503.php';
                }
                die();
            }
        }
        
        $query = trim($_SERVER['QUERY_STRING'],'/');

        self::$config = Configuration::getInstance();
        
//        $log = Log::getInstance();
//        $log->info("run");
//        $log->warning("two");
//        $log->error("error");


        
        
        
        Router::dispatch($query);

    }

}
