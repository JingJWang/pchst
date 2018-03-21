<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();
class home extends CI_Controller{  
    /**
     * 系统首页入口
     */
    public function index(){
        //检查是否来自百度搜索点击过来的
        if (isset($_SERVER["HTTP_REFERER"])) {
            $preg='/^https:\/\/www.baidu.com/';
            if(preg_match($preg, $_SERVER['HTTP_REFERER'])){
                $_SESSION['user_from'] = 'baidu';
            }
        }
        //判断终端 校验访问终端
        $this->load->library('user_agent');
        $user_agent= $this->agent->agent_string();
        if(strrpos($user_agent, 'Mobile')){
            $param = $this->uri->segment(4);
            if ($param!=1) {
                header("Location:http://wx.recytl.com/index.php/nonstandard/system/welcome");
            }
        }        
        //用户信息
        $user=currency::getUser();
        //读取交易额成交记录
        $this->load->model('common/static_model');
        $deal=$this->static_model->indexVolume();
        //获取品牌信息
        $this->load->model('home/brand_model');
        $brand = $this->brand_model->getBrand('5');
        if ($brand === false) {
            $shops = false;
        }else{
            $brand = array_slice($brand,0,13);
            $shops = $this->brand_model->getShops('2','0');
            $shops = ($shops === false)?false:array_slice($shops,0,6);
        }
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $this->load->model('notice_model');
        //页脚信息
        $texts = $this->notice_model->getAllNotice();
        $hotSeach=$this->config->item('popular_search');
        //热门资讯
        $information = $this->notice_model->hotInfomation();
        if ($information===false) {
            $information = '';
        }
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->caching = false;
        $smarty->assign('hotSeach',$hotSeach);
        $smarty->assign('top',$user);
        $smarty->assign('seo',$seo);
        $smarty->assign('deal',$deal);
        $smarty->assign('brand',$brand);
        $smarty->assign('shops',$shops);
        $smarty->assign('header',array('sign'=>'home'));
        $smarty->assign('information',$information);
        $smarty->assign('foots',$texts);
        $smarty->display('home.html');
    }
}