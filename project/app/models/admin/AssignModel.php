<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models\admin;
/**
 * Description of AssignModel
 *
 * @author james
 */
class AssignModel extends app\models\AppModel{
    //put your code here
    public function indexAction()
    {
        $conn = $this->DB;
        extract($this->params);
        
        $return = [];
	
	// Some SQL        

        $return['admins']=$rows;
        
        return $return;
    }
}
