<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of Cache
 *
 * @author james
 */
class Cache {
    //put your code here
    use TSingleton;
    
    public static function set($key,$data,$time=3600)
    {
        $file = CACHE.'/'.md5($key);
        $data_arr = array('data'=>$data,'time'=>time()+$time);
        file_put_contents($file, serialize($data_arr));
    }
    
    public static function get($key)
    {
        $file = CACHE.'/'.md5($key);
        if (file_exists($file))
        {
            $content = unserialize(file_get_contents($file));
            if (time() > $content['time'])
                return false;
            else
                return $content['data'];
        }
        else
            return false;
    }
    
    public static function drop($key)
    {
        $file = CACHE.'/'.md5($key);
        if (file_exists($file))
        {
            unlink($file);
        }
    }
}
