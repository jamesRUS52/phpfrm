<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;


use jamesRUS52\phpfrm\base\Controller;
use jamesRUS52\phpfrm\User;
use jamesRUS52\phpfrm\App;
/**
 * Description of AppController
 *
 * @author james
 */
class AppController extends Controller {
    //put your code here
    
    public function __construct($route) {
        parent::__construct($route);

        $user = User::getInstance();
        
        if (!$user->isAuth() && $this->controller != "Auth")
        {
            $http_referer = GetCurrentUrl();
            $user->setLastPage($http_referer);
            header ("Location: ".BASEURL."auth");
        }
        
        $this->setMeta( App::$config->getParam("app_name") , 'Система учета ресурсов Биллинг', 'Биллинг, заказ ресурсов, стоимость ресурсов','text/html;charset=utf-8');
    }
}
