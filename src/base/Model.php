<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm\base;

/**
 * Description of Model
 *
 * @author james
 */
class Model {
    //put your code here
    public $attributes = [];
    public $errors = [];
    public $rules = [];
    public $params = [];
    
    
    public function set($params)
    {
        $this->params = $params;
    }
}

