<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of DB
 *
 * @author james
 */
class DB {
    use TMultiton;

   /**
    * 
    * @param type $instanceName
    * @return \PDO
    */
    public static function getInstance($instanceName='app')
    {
        if (!isset(self::$instances[$instanceName])) {
            $db_conf = require_once CONF.'/db_'.$instanceName.'.php';
        
            if (array_key_exists('conn_opt', $db_conf) &&  is_array($db_conf['conn_opt']))
                $conn_opt = $db_conf['conn_opt'];
            else
                $conn_opt = array();

            if (array_key_exists('init_sql', $db_conf) &&  is_array($db_conf['init_sql']))
                $init_sql = $db_conf['init_sql'];
            else
                $init_sql = array();

            $pdo = new \PDO($db_conf['connection_string'],$db_conf['user'],$db_conf['password'],$conn_opt);
            #print "Connect success with param ";
            foreach ($init_sql as $sql)
                $pdo->exec($sql);
            
            self::$instances[$instanceName] = $pdo;
        }

        return self::$instances[$instanceName];
    }


}
