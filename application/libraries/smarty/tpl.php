<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'libs/Smarty.class.php';

class tpl{
    //smarty 对象
    public $smarty='';
    
    function __construct(){
        
        $this->smarty = new Smarty();
        $this->smarty->debugging = false;
        $this->smarty->caching = false;
        $this->smarty->cache_lifetime = 120;
        $this->smarty->cache_dir ='./smarty/cache/';
        $this->smarty->config_dir='./smarty/config/';
        $this->smarty->template_dir=array('./tpl/');
    
    }
    function getSmarty(){
        return $this->smarty;
    }
}