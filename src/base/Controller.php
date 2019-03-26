<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm\base;

/**
 * Description of Controller
 *
 * @author james
 */
abstract class Controller {
    //put your code here
    
    public $route;
    public $controller;
    public $view;
    public $prefix;
    public $model;
    public $action;
    public $layout;
    public $gzipview=FALSE;
    public $runmodel=TRUE;
    public $runview=TRUE;


    /**
     * Data for view
     * @var string[]
     */
    public $data = [];
    public $meta = [];
    /**
     * Input user params (GET and POST)
     * @var string[]
     */
    public $params = [];


    public function __construct($route) {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->action = $route['action'];
        $this->prefix = $route['prefix'];
        
        if (isset($_REQUEST))
            $this->params = $_REQUEST;
    }
    
    public function getView()
    {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->gzip = $this->gzipview;
        $viewObject->render($this->data);
    }
    public function set($data)
    {
        $this->data = $data;
    }
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function setMeta($title='',$desc='',$keywords='',$contenttype='')
    {
        $this->meta['title'] = $title;
        $this->meta['description'] = $desc;
        $this->meta['keywords'] = $keywords;
        $this->meta['content-type'] = $contenttype;
    }
    public function setTitle($title)
    {
        $this->meta['title'] = $title;
    }
}
