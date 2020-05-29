<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jamesRUS52\phpfrm;

/**
 * Description of User
 *
 * @author james
 */
class User {
    //put your code here
    
    use TSingleton;
    
    /**
     * login f.g. Ivanov.Ivan
     * @var string
     */
    public $login;
    /**
     * Full name, f.g. Иванов Иван Иванович
     * @var string
     */
    public $name;
    public $email;
    private $roles = [];
    public $lastPage;
    private $auth = false;
    public $id;
    private $emailLists = [];

    public function isAuth()
    {
        return $this->auth;
    }
    
    public function setUser($login,$name='',$email='',$roles=[],$id=FALSE)
    {
        $this->login = $login;
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
        $this->auth = TRUE;
        $this->id = $id;
        $_SESSION['user'] = $this;
    }
    
    public function droptUser()
    {
        User::$instance = NULL;
        unset($_SESSION['user']);
    }
    
    public function setRoles ($roles=[])
    {
        $this->roles = $roles;
        $_SESSION['user'] = $this;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
    
    public function hasRole($role)
    {
        if (array_key_exists($role, $this->roles) && $this->roles[$role] == TRUE)
            return true;
        else
            return false;
    }    
    /**
     * Check Has user one of needed role
     * @param string[] $roles need roles
     * @return boolean
     */
    public function hasRoles($roles)
    {
        foreach ($this->roles as $role => $flag)
        {
            if (!$flag)
                continue;
            foreach ($roles as $needrole)
            {
                if ($role == $needrole)
                    return true;
            }
        }
        return false;
    }
    
    public function AddRole($role)
    {
        $this->roles[$role] = TRUE;
        $_SESSION['user'] = $this;
    }
    
    public function setLastPage ($page)
    {
        $this->lastPage = $page;
        $_SESSION['user'] = $this;
    }
    
    public function getLastPage ()
    {
        return $this->lastPage;
    }
    
    public function __wakeup() {
        // When session is starting in APP() . it invoke this method to recreate object 
        self::$instance = $_SESSION['user'];
    }

    public function setEmailLists ($list) {
        $this->emailLists = $list;
    }

    public function getEmailLists() {
        return $this->emailLists;
    }
}
