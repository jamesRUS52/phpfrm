<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of Router
 *
 * @author james
 */
class Router {
    //put your code here
    protected static $routes = [];
    protected static $route = [];
    
    public static function add($regexp,$route=[])
    {
        self::$routes[$regexp] = $route;
    }
    #список всех маршрутов
    public static function getRoutes()
    {
        return self::$routes;
    }
    # текущий маршрут
    public static function getRoute()
    {
        return self::$route;
    }
    public static function dispatch($url)
    {
        #print $url."<BR>";
        $url = self::removeQueryString($url);
        #print $url;
        if (self::matchRoute($url))
        {
            //$controller = 'app\controllers\\'.self::$route['prefix'].self::$route['controller'].'Controller';
            $controller = APPCLASSBASE.'\controllers\\'.self::$route['prefix'].self::$route['controller'].'Controller';
            if (class_exists($controller))
            {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action'])."Action";
                if (method_exists($controllerObject, $action))
                {
                    $controllerObject->$action();
                    
                    if ($controllerObject->runmodel)
                    {
                        $model = APPCLASSBASE.'\models\\'.self::$route['prefix'].self::$route['controller'].'Model';
                        if (class_exists($model))
                        {
                            $modelObject = new $model();
                            $modelAction = $controllerObject->action."Action";
                            if (method_exists($modelObject, $modelAction))
                            {
                                $modelObject->set($controllerObject->params); // set Input data for model
                                $data = $modelObject->$modelAction();
                                $controllerObject->set($data); // set Data for view 
                            }
                            else
                                throw new Exception("Метод {$action} в модели {$model} не найден",404);
                        }
                        else
                            throw new Exception("Модель {$model} не найдена",404);
                    }
                    
                    if ($controllerObject->runview)
                        $controllerObject->getView();
                }
                else
                {
                    throw new Exception("Метод {$action} в контроллер {$controller} не найден",404);
                }
            }
            else
            {
                throw new Exception("Контроллер {$controller} не найден",404);
            }
        }
        else
            throw new Exception("Страница не найдена {$url}",404);
    }
    public static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route)
        {
            if (preg_match("#{$pattern}#", $url, $matches))
            {
                foreach ($matches as $k => $v)
                {
                    if (is_string($k))
                        $route[$k]=$v;
                }
                if (empty($route['action']))
                    $route['action']='index';
                if (!isset($route['prefix']))
                    $route['prefix']='';
                else
                    $route['prefix'].='\\';
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                #debug(self::$route);
                return true;
            }
        }
        return false;
    }
    
    # for psr standar for Controllers MainController
    protected static function upperCamelCase($name)
    {
        return str_replace(' ','',ucwords(str_replace('-', ' ',$name)));
    }
    
    # for psr standar for actions mainActions
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
    
    # с флагом QSA get параметры добавляются через & в правиле реврайта
    protected static function removeQueryString($url)
    {
        
        if (strpos($url, "=")!==false || strpos($url, "&")!==false)
        {
            if (strpos($url, "&"))
                return rtrim(explode ('&', $url)[0],'/');
            else
                return "";
        }
        else
            return $url;
    }
}
