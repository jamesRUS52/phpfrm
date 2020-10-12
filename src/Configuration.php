<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of Configuration
 *
 * @author james
 */
class Configuration {
    //put your code here
    use TSingleton;
    
    private function __construct() {
        if (file_exists(CONF.'/app.env'))
        {
            $dotenv = \Dotenv\Dotenv::createImmutable(CONF,'app.env');
            $this->genMembers($dotenv);
        }
    }

    public function getParam($parameter)
    {
        return $_ENV[strtolower($parameter)];
    }
    
    public function isParam($parameter)
    {
        if (empty($_ENV[strtolower($parameter)]))
            return FALSE;
        else
            return TRUE;
    }
    
    /**
     * 
     * @param \Dotenv\Dotenv $dotenv
     */
    private function genMembers($dotenv)
    {
        foreach (array_keys($dotenv->load()) as $name) {
            $this->$name = $_ENV[$name];
        }
    }
}
