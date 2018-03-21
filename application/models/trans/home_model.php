<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /*
     * 用户登录检查
     */
    function check_user(){
    	$pwd=substr(hash('sha256',$this->pwd),0,20);
    	$sql='SELECT trans_id as id,trans_name as name,trans_pwd as pwd,trans_pid as pid,trans_phone as phone,tag,
    			trans_proportion as proportion,trans_mark as mark from h_trans_user where trans_name="'.$this->name.'" 
    			and trans_pwd ="'.$pwd.'" and  trans_status = 1';
    	$query=$this->db->query($sql);
    	if($query->num_rows == 1 ){
    		$result=$query->result_array();
    		if($result[0]['pwd']== $pwd){
    			$_SESSION['id']=$result[0]['id'];
    			$_SESSION['pid']=$result[0]['pid'];
    			$_SESSION['name']=$result[0]['name'];
    			$_SESSION['tag']=$result[0]['tag']; //判断是总代还是二级管理员
    			$_SESSION['mark']=$result[0]['mark'];
    			$_SESSION['proportion']=$result[0]['proportion'];
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    /*
     * 验证输入的手机号是否注册系统
     */
    function selectAgent(){
    	$phone = $this->phone;
    	if($phone !=''){
    		$sql='select wx_id from h_wxuser where wx_mobile="'.$phone.'"';
    		$query=$this->db->query($sql);
    		$result=$query->num_rows();
    		return $result;
    	}
    }
    /*
     * 添加新代理
     */
    function addNewAgent(){
    	//加载生成二维码的插件
    	$this->load->helper('phpqrcode');
    	//二维码内容
    	$value = 'http://test.recytl.com/index.php/nonstandard/system/usereg';
    	//容错级别
    	$errorCorrectionLevel = 'L';
    	//生成图片大小
    	$matrixPointSize = 3;
    	//随机生成六位 数字+字母
    	$randStr = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    	$rand = substr($randStr,0,6);
    	$password = substr(hash('sha256','123456'),0,20);
    	//随机生成二维码图片并保持到数据中
    	$randqrcode = substr($randStr,0,12);
    	//图片名
    	$path=getcwd().'/static/trans/qrcodeimg/';
    	$name='qrcode.png';
    	$file=$path.$randqrcode.$name;
    	$content=$value.'?rand='.substr($randqrcode,0,6);
    	$sqlfile='http://'.$_SERVER['HTTP_HOST'].'/static/trans/qrcodeimg/'.$randqrcode.$name;
    	switch ($this->tag){
    		case '2':
    			QRcode::png($content,$file,$errorCorrectionLevel,$matrixPointSize, 2);
	    		$data = array(
	    				'promoter_name' => $this->phone,
	    				'promoter_pwd' =>$password,
	    				'promoter_phone' => $this->phone,
	    				'trans_id' => $this->id,
	    				'promoter_status' => '1',
	    				'promoter_proportion' => $this->proportion,
	    				'tag'=>'3',
	    				'promoter_mark' =>'1',
	    				'promoter_invitation' =>$rand,
	    				'promoter_qrcode' =>$sqlfile,
	    				'promoter_jointime' => time()
	    		);
	    		$pro_sql='select promoter_id from h_promoter_user where promoter_name="'.$this->phone.'"';
	    		$pro_query=$this->db->query($pro_sql);
	    		$pro_result=$pro_query->num_rows();
	    		if($pro_result['promoter_id']==null){
	    			$sql=$this->db->insert('h_promoter_user',$data);
	    			if($sql){
	    				return true;
	    			}else{
	    				return false;
	    			}
	    		}
	    		break;
    		case '1':
    		$data = array(
    				'trans_name' => $this->phone,
    				'trans_pwd' =>$password,
    				'trans_phone' => $this->phone,
    				'trans_pid' => $this->id,
    				'trans_status' => '1',
    				'trans_proportion' => $this->proportion,
    				'tag'=>'2',
    				'trans_mark' =>'1',
    				'trans_jointime' => time()
    		);
    	 	$trans_sql='select trans_id from h_trans_user where trans_name="'.$this->phone.'"';
    		$trans_query=$this->db->query($trans_sql);
    		$trans_result=$trans_query->result_array();
    		if(sizeof($trans_result)<1){
    			$sql=$this->db->insert('h_trans_user',$data);
    			if($sql){
    				return true;
    			}else{
    				return false;
    			}
    		}
    		break;
    		default:
    			return false;
    	}
    }
    /*
     * 冻结二级代理账户
     */
    function uptrans(){
    	$sql = 'update h_trans_user set trans_status = 0 where trans_id ='.$this->id;
    	$query = $this->db->query($sql);
   		if($query == true ){
    		return true;
    	}else{
    		return false;
    	}
    }
    /*
     * 冻结推广员账户
     */
    function uppromoter(){
    	$sql = 'update h_promoter_user set promoter_status = 0 where promoter_id ='.$this->id;
    	$query = $this->db->query($sql);
    	if($query == true ){
    		return true;
    	}else{
    		return false;
    	}
    }
}