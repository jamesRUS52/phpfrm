<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of ErrorHandler
 *
 * @author james
 */
class ErrorHandler {
    //put your code here
    public function __construct() {
        if (DEBUG)
            error_reporting (-1);
        else
            error_reporting (0);
        set_exception_handler([$this,"exceptionHandler"]);
        register_shutdown_function([$this,"fatalHandler"]);
    }
    public function exceptionHandler($e)
    {
        
        $log = Log::getInstance();
        if ($e instanceof Exception)
        {
            $logcore = Log::getInstance("core", "app");
            $logcore->error($e->getMessage(), array("File"=>$e->getFile(),"Line"=>$e->getLine(),"Code"=>$e->getCode(),"Trace"=>$e->getTraceAsString()));
        }
        else
            $log->error($e->getMessage(), array("File"=>$e->getFile(),"Line"=>$e->getLine(),"Code"=>$e->getCode(),"Trace"=>$e->getTraceAsString()));

        if ($e->getCode() == 404 && $e instanceof Exception)
            $this->displayError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(),404);
        else
            $this->displayError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(),500);

    }
    
    public function fatalHandler()
    {
        
        $errfile = "unknown file";
        $errstr  = "shutdown";
        $errno   = E_CORE_ERROR;
        $errline = 0;

        $error = error_get_last();

        if( $error !== NULL) 
        {
            $errno   = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];
            
            $log = Log::getInstance();
            switch ($errno)
            {
                case 1: #E_ERROR
                case 4: #E_PARSE
                case 16: #E_CORE_ERROR
                case 64: #E_COMPILE_ERROR
                case 256: #E_USER_ERROR
                case 2048: #E_STRICT
                case 4096: #E_RECOVERABLE_ERROR
                    $log->critical($errstr, array("File"=>$errfile,"Line"=>$errline,"Code"=>$errno));
                    break;
                case 8: #E_NOTICE
                case 1024: #E_USER_NOTICE
                case 8192: #E_DEPRECATED
                case 16385: #E_USER_DEPRECATED
                    $log->notice($errstr, array("File"=>$errfile,"Line"=>$errline,"Code"=>$errno));
                    break;
                case 2: #E_WARNING
                case 32: #E_CORE_WARNING
                case 128: #E_COMPILE_WARNING
                case 512: #E_USER_WARNING
                    if ($errstr!="ldap_bind(): Unable to bind to server: Invalid credentials") // E_WARNING
                        $log->warning($errstr, array("File"=>$errfile,"Line"=>$errline,"Code"=>$errno));
                    break;
                default : #E_ALL  32767
                    $log->critical($errstr, array("File"=>$errfile,"Line"=>$errline,"Code"=>$errno));
                    break;
            }
            
            if ($errstr!="ldap_bind(): Unable to bind to server: Invalid credentials") // E_WARNING
                $this->displayError($errno, $errstr, $errfile, $errline,500);
        }
        
        
    }
    

    protected function displayError($errno,$errstr,$errfile,$errline,$response=404)
    {
        
        http_response_code($response);
        
        if ($response==404 && !DEBUG)
        {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                print "Page not found";
            }
            else
            {
                require WWW.'/errors/404.php';
            }
            die();
        }
        if (DEBUG)
        {
            require WWW.'/errors/dev.php';
        }
        else
        {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                print "Internal server error";
            }
            else
            {
                require WWW.'/errors/500.php';
            }
            
        }

        die();
        exit();
    }


}
