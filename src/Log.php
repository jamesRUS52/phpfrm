<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;

/**
 * Description of Log
 *
 * @author james
 */
class Log {
    use TMultiton;
    
    /**
     * 
     * @param type $instanceName
     * @return \Monolog\Logger
     */
    public static function getInstance($channel='app',$logname='app')
    {
        $instanceName = $logname."_".$channel;
        if (!isset(self::$instances[$instanceName])) {
            $log_conf = require CONF.'/log_'.$logname.'.php';
            // Create the logger
            $logger = new Logger($channel);
            foreach ($log_conf as $log)
            {
                $loglevel = Logger::INFO;
                switch ($log['level'])
                {
                    case "DEBUG" : $loglevel = Logger::DEBUG;
                        break;
                    case "INFO" : $loglevel = Logger::INFO ;
                        break;
                    case "NOTICE" : $loglevel = Logger::NOTICE;
                        break;
                    case "WARNING" : $loglevel = Logger::WARNING;
                        break;
                    case "ERROR" : $loglevel = Logger::ERROR;
                        break;
                    case "CRITICAL" : $loglevel = Logger::CRITICAL;
                        break;
                    case "ALERT" : $loglevel = Logger::ALERT;
                        break;
                    case "EMERGENCY" : $loglevel = Logger::EMERGENCY;
                        break;
                }
                if ($log['logger']=="file")
                {
                    // Now add some handlers
                    $logger->pushHandler(new StreamHandler(LOGS.'/'.$log['file'], $loglevel));
                }
                else if ($log['logger']=="email")
                {
                    // Create the Transport
                    $transport = (new \Swift_SmtpTransport($log['host'], $log['port']))
                                ->setUsername($log['user'])
                                ->setPassword($log['password']);

                    // Create the Mailer using your created Transport
                    $mailer = new \Swift_Mailer($transport);

                    $message = (new \Swift_Message($log['subject']))
                                ->setFrom([$log['from_email'] => $log['from_name']])
                                ->setTo([$log['to']])
                                ->setBody('Here is the message itself. It will be replaced');

                    $logger->pushHandler(new \Monolog\Handler\SwiftMailerHandler($mailer,$message,$loglevel,TRUE));
                }
            }
            

            self::$instances[$instanceName] = $logger;
        }

        return self::$instances[$instanceName];
    }


    
}
