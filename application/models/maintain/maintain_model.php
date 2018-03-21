<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class maintain_model extends CI_Model{
    
    
    /**
     * 查询当前自动报价表未报价的数据是否已经超过设置的临界值
     * @param  int   $number 系统设置的临界值
     * @return bool  超过返回 false | 未超过返回true 
     */
    function getTaskOrder(){
        
        
    }
    
}