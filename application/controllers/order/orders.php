<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
header('Content-type:text/html;charset=utf-8');

class Orders extends CI_Controller {
    /**
     * 我的订单 ----获取订单列表
     * @param    int   status  订单状态
     * @return   成功返回 string 订单列表  | 结果为空 或者 失败返回  原因
     */
    function getOrderList(){
        currency::isOnline();
        $user=currency::getUser();//用户信息
        if (!is_numeric($userid=$_SESSION['user_id'])) {
            exit();
        }
        $hotSeach=$this->config->item('popular_search');
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('se_Left',array('sign_f'=>'order','sign_s'=>'mobile'));
        $smarty->assign('header',array('sign'=>'home'));
        $smarty->assign('top',$user);
        $smarty->assign('hotSeach',$hotSeach);
        $smarty->assign('foots',$texts);
        $smarty->display('order/orders.html');
    }
    /**
     * 我的订单 ----获取订单列表
     * @param    int   status  订单状态
     * @return   成功返回 string 订单列表  | 结果为空 或者 失败返回  原因
     */
    function getList(){
        $status = $this->input->post('status');
        if ($status!=1&&$status!=2) {
            exit();
        }
        currency::isOnline();
        $user=currency::getUser();//用户信息
        if (!is_numeric($userid=$_SESSION['user_id'])) {
            exit();
        }
        $this->load->model('order/orders_model');
        $result = $this->orders_model->GetOrderList($userid,$status);
        currency::Output($this->config->item('request_succ'),'','',$result);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */