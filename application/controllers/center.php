<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
/**
 * 
 * @author xiaotao
 * 个人中心模块
 */
class  center extends CI_Controller{
    
    /**
     * 显示个人中心
     */
    function info(){
        //校验用户时候在线
        currency::isOnline();        
        $user=currency::getUser();
        //获取登录用户信息
        $this->load->model('common/center_model');
        $this->center_model->id=$_SESSION['user_id'];        
        $info=$this->center_model->centerInfo();
        $order=$this->center_model->orderOverView(); 
        $hotSeach=$this->config->item('popular_search');
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('top',$user);
        $smarty->assign('user',$info);
        $smarty->assign('order',$order);
        $smarty->assign('hotSeach',$hotSeach);
        $smarty->assign('seo',$seo);
        $smarty->assign('se_Left',array('sign_f'=>'center'));
        $smarty->assign('header',array('sign'=>'home'));
        $smarty->assign('foots',$texts);
        $smarty->display('center.html');
    }
    /**
     * 显示安全中心
     */
    function safe() {
        //校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();
        
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('header',array('sign'=>'home'));
        $smarty->assign('top',$user);
        $smarty->display('center/security.html');
    }
    /**
     * 404界面地址
     */
    function nopage(){
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->display('mistake.html');
    }
}