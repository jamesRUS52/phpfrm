<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function debug($var,$print_type=TRUE)
{
    if (is_object($var))
    {
        print "<pre>";var_dump ($var);print "</pre>";
    }
    else if (is_array($var))
    {
        if ($print_type===TRUE)
        {
            print "<pre>";var_dump ($var);print "</pre>";
        }
        else
        {
            print "<pre>";print_r ($var);print "</pre>";
        }
    }
    else
    {
        if ($print_type===TRUE)
            var_dump($var);
        else
            print ($var);
    }
}

function getCurrentUrl()
{
    $http_referer  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']== "on") ? "https://" : "http://";
    $http_referer .= $_SERVER['SERVER_NAME'];
    $http_referer .= ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) ? ":".$_SERVER['SERVER_PORT'] : "";
    $http_referer .= (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : "/";
    return $http_referer;
}