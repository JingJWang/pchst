<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
header('Content-type:text/html;charset=utf-8');

class Address extends CI_Controller {
    /**
     * 获取用户的地址
     */
	public function getadres()
	{
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        $this->load->model('address_model');
        $useradrss = $this->address_model->getUAdres($user_id);
        
        $hotSeach=$this->config->item('popular_search');
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
	    $this->load->library('smarty/tpl');
	    $smarty=$this->tpl->getSmarty();
        $smarty->assign('top',$user);
        $smarty->assign('hotSeach',$hotSeach);
        $smarty->assign('se_Left',array('sign_f'=>'management','sign_s'=>'adres'));
        $smarty->assign('header',array('sign'=>'home'));
	    $smarty->assign('adres',$useradrss);
        $smarty->assign('foots',$texts);
	    $smarty->display('addressManage.html');
	}
	/**
	 * 检查参数是否正确
	 * @param       string       name         收件人姓名
	 * @param       int          phone        收件手机号码
	 * @param       string       city         城市
	 * @param       string       detail       详细地址
	 * @param       bool          default      是否默认
	 * @return      正确返回数组
	 */
	private function check(){
        $check['receive_phone'] = $this->input->post('phone',true);
        $check['receive_name'] = currency::filter($this->input->post('name',true));
        $check['receive_province'] = currency::filter($this->input->post('province',true));
        $check['receive_city'] = currency::filter($this->input->post('city',true));
        $check['receive_area'] = currency::filter($this->input->post('area',true));
        $check['receive_details'] = currency::filter($this->input->post('adr_detail',true));
        $check['receive_status'] = ($this->input->post('default',true)==2)?2:1;
        if (empty($check['receive_name'])||empty($check['receive_phone'])||empty($check['receive_province'])
        	||empty($check['receive_city'])||empty($check['receive_area'])||empty($check['receive_details'])) {
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_no_complete'),'','');
        }
        if (strlen($check['receive_details'])>300||strlen($check['receive_city'])>45||strlen($check['receive_name'])>48
        	||strlen($check['receive_province'])>36||strlen($check['receive_area'])>36) {
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_too_long'),'','');
        }
        if(!preg_match("/^(1[3|4|5|7|8][0-9]{9})$/",$check['receive_phone'])){
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_mobile_err'),'','');
        }
        return $check;
	}
	/**
	 * 添加用户地址
	 * @param       int          userid       用户的id
	 * @param       string       name         收件人姓名
	 * @param       int          phone        收件手机号码
	 * @param       string       city         城市
	 * @param       string       detail       详细地址
	 * @param       bool          default      是否默认
	 */
	function addaddress(){
        // 校验用户时候在线
        currency::isOnline();
        //获取插入信息并验证信息
        $insert = $this->check();
        $insert['user_id'] = $_SESSION['user_id'];
        if (!is_numeric($insert['user_id'])) {
        	exit();
        }
        //获取原来的地址，得到地址数和默认地址
        $nowDefIid = NULL;//记录默认地址id
        $this->load->model('address_model');
        $useradrss = $this->address_model->getUAdres($insert['user_id']);
        if ($useradrss!==false) {
            if (count($useradrss)>=5) {
                currency::Output($this->config->item('request_fall'),$this->lang->line('adress_add_more'),'','');
            }
            foreach ($useradrss as $k => $v) {
            	if ($v['status']==2) {
            	    $nowDefIid = $v['id'];
            	    break;
            	}
            }
        }
        $result = $this->address_model->inaddress($insert,$nowDefIid);
        if ($result===false) {//更新失败
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_add_fall'),'','');
        }
        currency::Output($this->config->item('request_succ'),$this->lang->line('adress_add_suc'),'',$result);
	}
	/**
	 * 更新用户id
	 * @param        int        userid      用户的id
	 * @param        int        adressid    地址的id
	 * @param        string       name         收件人姓名
	 * @param        int          phone        收件手机号码
	 * @param        string       city         城市
	 * @param        string       detail       详细地址
	 * @param        bool          default      是否默认
	 */
	function upaddress(){
        // 校验用户时候在线
        currency::isOnline();
        $update = $this->check();
        $user_id = $_SESSION['user_id'];
        $adressid = $this->input->post('adressid',true);
        if (!is_numeric($user_id)||!is_numeric($adressid)) {
        	exit();
        }
        //获取原来的地址，得到地址数和默认地址
        $nowDefIid = NULL;//记录默认地址id
        $isTheUser = false;
        $this->load->model('address_model');
        $useradrss = $this->address_model->getUAdres($user_id);
        if ($useradrss===false) {//没有地址
        	exit();
        }
        foreach ($useradrss as $k => $v) {
        	if ($v['id']==$adressid) {//确保此更新地址是此用户的
        		$isTheUser = true;
        	}
            if ($v['status']==2&&$v['id']!=$adressid) {
                $nowDefIid = $v['id'];
            }
        }
        if ($isTheUser===false) {//地址不是此用户的
        	exit();
        }
        $result = $this->address_model->upaddress($update,$adressid,$nowDefIid);
        if ($result===false) {//更新失败
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_up_fall'),'','');
        }
        currency::Output($this->config->item('request_succ'),$this->lang->line('adress_up_suc'),'','');
	}
	/**
	 * 检查用户获取的地址是否合法
	 * @param        int        adressid      地址的id
	 * @return       正确返回数组|错误返回false
	 */
	private function checkone(){
        $user_id = $_SESSION['user_id'];
        $adressid = $this->input->post('adressid',true);
        if (!is_numeric($user_id)||!is_numeric($adressid)) {
        	return false;
        }
        $this->load->model('address_model');
        $thisadrss = $this->address_model->getOneAdre($adressid);
        if ($thisadrss===false||$thisadrss['0']['uid']!=$user_id) {//没有地址或地址不是此用户的
        	return false;
        }
        return $thisadrss;
	}
	/**
	 * 删除地址
	 * @param        int        adressid      地址的id
	 */
	function deladress(){
        currency::isOnline();
        $addreinfo = $this->checkone();
        if ($addreinfo===false) {
        	exit();
        }
        $result = $this->address_model->deladdre($addreinfo['0']['id']);
        if ($result===false) {
            currency::Output($this->config->item('request_succ'),$this->lang->line('adress_del_fall'),'','');
        }
        currency::Output($this->config->item('request_succ'),$this->lang->line('adress_del_suc'),'','');
	}
	/**
	 * 获取某个地址
	 */
	function getoneadr(){
		$_POST['adressid'] = 101;
        currency::isOnline();
        $addreinfo = $this->checkone();
        if ($addreinfo===false) {
        	exit();
        }
        var_dump($addreinfo);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */