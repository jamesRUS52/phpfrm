<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets\menu;

/**
 * Description of Menu
 *
 * @author james
 */
class Menu {
    //put your code here
    private $items = [];
    private $layout;

    public function __construct($menu='app',$layout = 'layout_app') {
        $this->items = require_once CONF.'/menu_'.$menu.'.php';
        $this->layout = WIDGETS.'/menu/'. $layout.'.php';
        
    }
    
    public function __toString() {
        return $this->render();
    }

    public function render()
    {
        $items = $this->items;
        ob_start();
        require_once $this->layout;
        $content = ob_get_clean();
        return $content;
    }
}
