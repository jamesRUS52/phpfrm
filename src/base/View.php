<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm\base;

/**
 * Description of View
 *
 * @author james
 */
class View {
    //put your code here
    public $route;
    public $controller;
    public $view;
    public $prefix;
    public $model;
    public $layout;
    public $data = [];
    public $meta = [];
    public $gzip = FALSE;


    public function __construct($route, $layout='', $view='', $meta=[]) {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        if ($layout === FALSE) # не будет лайаута вообще (для ajax)
        {
            $this->layout = FALSE;
        }
        else
        {
            $this->layout = $layout ?: LAYOUT; # если не передан лейаут то используется дефолтный из настроек по умолчанию
        }
    }
    
    public function render($data)
    {
        if (is_array($data))
            extract ($data);
        
        $prefix = $this->prefix != "" ? rtrim($this->prefix,'\\').'/' : $this->prefix;
        
        $viewFile = APP."/views/{$prefix}{$this->controller}/{$this->view}.php";
        if (is_file($viewFile))
        {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        }
        else
        {
            throw new \jamesRUS52\phpfrm\Exception("Не найден вид {$viewFile}",500);
        }
        if ($this->layout !== FALSE)
        {
              $layoutFile = APP."/views/layouts/{$this->layout}.php";
              if (is_file($layoutFile))
              {
                  $meta = $this->getMeta();
                  require_once $layoutFile;
              }
              else
              {
                  throw new \jamesRUS52\phpfrm\Exception("Не найден шаблон {$layoutFile}",500);
              }
        }
        else // для ajax или любого запроса без лейаута
        {
            if ($this->gzip)
                echo base64_encode(gzdeflate($content, 5, ZLIB_ENCODING_DEFLATE));
            else
                echo $content;
        }
    }
    
    public function getMeta()
    {
        $meta = "";
        foreach ($this->meta as $k => $v)
        {
            if ($k == "title")
                $meta .= "<TITLE>{$v}</TITLE>\n";
            else if ($k == "content-type")
                $meta .= "<meta http-equiv=\"{$k}\" content=\"{$v}\">\n";
            else
                $meta .= "<meta name=\"{$k}\" content=\"{$v}\">\n";
        }
        return $meta;
    }
}
