<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    //推广员用户登陆检查
    function  check_user(){
    	$pwd=substr(hash('sha256',$this->pwd),0,20);
    	$sql='SELECT promoter_id as id,promoter_name as name,promoter_pwd as pwd,trans_id as pid,promoter_phone as phone,promoter_invitation as invitation,promoter_proportion as proportion,promoter_mark as mark,tag from h_promoter_user
    			where promoter_name="'.$this->name.'" and promoter_pwd ="'.$pwd.'" and  promoter_status = 1';
    	$query=$this->db->query($sql);
    	if($query->num_rows == 1 ){
    		$result=$query->result_array();
    		if($result[0]['pwd']== $pwd){
    			$_SESSION['id']=$result[0]['id'];
    			$_SESSION['pid']=$result[0]['pid'];
    			$_SESSION['name']=$result[0]['name'];
    			$_SESSION['invitation']=$result[0]['invitation'];//推广码
    			$_SESSION['proportion']=$result[0]['proportion'];//分成比例
    			$_SESSION['tag']=$result[0]['tag'];//推广员的标识
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    //修改用户密码
    function update_user(){
    	//$name = $_SESSION['name'];
    	$pwd=substr(hash('sha256',$this->pwd),0,20);
    	if($this->tag =='3'){
    		$sql = 'update h_promoter_user set promoter_pwd ="'.$pwd.'" where promoter_name ="'.$this->name.'" and promoter_status = 1';
    	}else{
    		$sql = 'update h_trans_user set trans_pwd ="'.$pwd.'" where trans_name ="'.$this->name.'" and trans_status = 1';
    	}
    	$res = $this->db->query($sql);
    	if($res == true ){
    		return true;
    	}else{
    		return false;
    	}
    }
}