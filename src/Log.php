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
                    $logger->pushProcessor(function ($record) {
                        $user_vars = [];
                        foreach (get_object_vars(\jamesRUS52\phpfrm\User::getInstance()) as $prop => $val) {
                            if (!is_array($val))
                                $user_vars[] = $prop . ": " . $val;
                            else
                                $user_vars[] = $prop . ": " . '['. implode(',',$val).']';
                        }
                        $roles = [];
                        foreach (\jamesRUS52\phpfrm\User::getInstance()->getRoles() as $role => $is)
                            $roles[] = $role."=".($is ? "True": "False");
                        $user_vars[] = "Roles: ".implode(",", $roles);
                        $user_vars[] = "Auth: ".(\jamesRUS52\phpfrm\User::getInstance()->isAuth()?"True":"False");
                        $record['extra']['user'] = implode("; ", $user_vars);

                        $server = isset($_SERVER['SERVER_NAME']) ? "Server: {$_SERVER['SERVER_NAME']}; ":"";
                        $URL = isset($_SERVER['REQUEST_URI']) ? "URL: {$_SERVER['REQUEST_URI']}; ":"";
                        $Method = isset($_SERVER['REQUEST_METHOD']) ? "Method: {$_SERVER['REQUEST_METHOD']}; ":"";
                        $IP = isset($_SERVER['REMOTE_ADDR']) ? "IP: {$_SERVER['REMOTE_ADDR']}; ":"";
                        $Referrer = isset($_SERVER['HTTP_REFERER']) ? "Referrer: {$_SERVER['HTTP_REFERER']}; ":"";
                        $Agent = isset($_SERVER['HTTP_USER_AGENT']) ? "Agent: {$_SERVER['HTTP_USER_AGENT']}; ":"";
                        $GetParams = "Get Params: [";
                        foreach ($_GET as $k => $v)
                        {
                            if (is_array($v))
                                $GetParams .= $k."=>". json_encode($v)."; ";
                            else
                                $GetParams .= $k."=>".$v."; ";
                        }
                        $GetParams .= "]; ";
                        $PostParams = "Post Params: [";
                        foreach ($_POST as $k => $v)
                        {
                            if (is_array($v))
                                $PostParams .= $k."=>". json_encode($v)."; ";
                            else
                                $PostParams .= $k."=>".$v."; ";
                        }
                        $PostParams .= "]; ";
                        $record['extra']['web'] = $server.$URL.$Method.$IP.$Referrer.$Agent.$GetParams.$PostParams;
                        
                        return $record;
                    });

                }
                else if ($log['logger']=="email")
                {
                    // Create the Transport
                    $transport = (new \Swift_SmtpTransport($log['host'], $log['port']))
                                ->setUsername($log['user'])
                                ->setPassword($log['password']);

                    // Create the Mailer using your created Transport
                    $mailer = new \Swift_Mailer($transport);

                    $log['to'] = (!is_array($log['to'])) ? array($log['to']) : $log['to'];
                    
                    $message = (new \Swift_Message($log['subject']))
                                ->setFrom([$log['from_email'] => $log['from_name']])
                                ->setTo($log['to'])
                                ->setBody('Here is the message itself. It will be replaced');

                    $logger->pushHandler(new \Monolog\Handler\SwiftMailerHandler($mailer,$message,$loglevel,TRUE));
                    $logger->pushProcessor(function ($record) {
                        $user_vars = [];
                        foreach (get_object_vars(\jamesRUS52\phpfrm\User::getInstance()) as $prop => $val)
                            $user_vars[]=$prop.": ".$val;
                        $roles = [];
                        foreach (\jamesRUS52\phpfrm\User::getInstance()->getRoles() as $role => $is)
                            $roles[] = $role."=".($is ? "True": "False");
                        $user_vars[] = "Roles: ".implode(",", $roles);
                        $user_vars[] = "Auth: ".(\jamesRUS52\phpfrm\User::getInstance()->isAuth()?"True":"False");
                        $record['extra']['user'] = implode("; ", $user_vars);
                        
                        $server = isset($_SERVER['SERVER_NAME']) ? "Server: {$_SERVER['SERVER_NAME']}; ":"";
                        $URL = isset($_SERVER['REQUEST_URI']) ? "URL: {$_SERVER['REQUEST_URI']}; ":"";
                        $Method = isset($_SERVER['REQUEST_METHOD']) ? "Method: {$_SERVER['REQUEST_METHOD']}; ":"";
                        $IP = isset($_SERVER['REMOTE_ADDR']) ? "IP: {$_SERVER['REMOTE_ADDR']}; ":"";
                        $Referrer = isset($_SERVER['HTTP_REFERER']) ? "Referrer: {$_SERVER['HTTP_REFERER']}; ":"";
                        $Agent = isset($_SERVER['HTTP_USER_AGENT']) ? "Agent: {$_SERVER['HTTP_USER_AGENT']}; ":"";
                        $GetParams = "Get Params: [";
                        foreach ($_GET as $k => $v)
                        {
                            if (is_array($v))
                                $GetParams .= $k."=>". json_encode($v)."; ";
                            else
                                $GetParams .= $k."=>".$v."; ";
                        }
                        $GetParams .= "]; ";
                        $PostParams = "Post Params: [";
                        foreach ($_POST as $k => $v)
                        {
                            if (is_array($v))
                                $PostParams .= $k."=>". json_encode($v)."; ";
                            else
                                $PostParams .= $k."=>".$v."; ";
                        }
                        $PostParams .= "]; ";
                        $record['extra']['web'] = $server.$URL.$Method.$IP.$Referrer.$Agent.$GetParams.$PostParams;
                        return $record;
                    });
                }
            }
            

            self::$instances[$instanceName] = $logger;
        }

        return self::$instances[$instanceName];
    }


    
}
