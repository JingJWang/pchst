<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class metal extends CI_Controller{
    
    
    /**
     * 贵重金属回收首页
     */
    function  index(){
        //如果用户登录获取登录信息
        $user=currency::getUser();
        $this->load->model('notice_model');
        //读取贵重金属信息        
        $type=$this->config->item('metal_type');
        $purity=array(
                '1'=>$this->config->item('gold_purity'),
                '2'=>$this->config->item('platinum_purity'),
                '3'=>$this->config->item('silver_purity')
        );
        $classify=$this->config->item('metal_classify');
        $price=$this->metalPrice();
        $metal=array('type'=>$type,'purity'=>$purity,'classify'=>$classify,'price'=>$price);
        //获取站点底部导航
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        //载入模板文件
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('metal',$metal);
        $smarty->assign('top',$user);
        $smarty->assign('seo',$seo);
        $smarty->assign('header',array('sign'=>'metal'));
        $smarty->assign('foots',$texts);
        $smarty->display('metal/metal.html');       
    }
    /**
     * 获取缓存的redis数据
     * @return array $price  返回当前 黄金 铂金  白金的价格
     */
    function metalPrice(){
        $this->load->model('metal/price_model');
        $resp=$this->price_model->jhMetalData();
        if($resp ===  false){
            return false;
        }
        $metal=json_decode($resp,true);
        $price=array('1'=>$metal['5']['midpri'],'2'=>$metal['7']['midpri'],'3'=>$metal['6']['midpri']);
        return $price;
    }
    /**
     * 处理用户提交的贵金属订单
     */
    function submit(){        
        //获取提交订单参数
        $type=$this->input->post('type',true);//类型  1 黄金 2 铂金 3 白银
        if(!in_array($type, array(1,2,3))){
            currency::Output($this->config->item('request_fall'),'金属类型为必填选项!');
        }
        $purity=$this->input->post('purity',true); //纯度
        switch ($type){
            case '1':
                $optionPurty=$this->config->item('gold_purity');
                break;
            case '2':
                $optionPurty=$this->config->item('silver_purity');
                break;
            case '3':
                $optionPurty=$this->config->item('platinum_purity');
                break;
        }
        if(!in_array($purity,$optionPurty)){
            currency::Output($this->config->item('request_fall'),'纯度类型为必填选项!');
        }
        $classify=$this->input->post('classify',true);//分类 
        $optionClassify=$this->config->item('metal_classify');
        if(!in_array($classify,$optionClassify)){
            currency::Output($this->config->item('request_fall'),'金属用途类型为必填选项!');
        }
        $weight=$this->input->post('grams',true);//重量
        if(!is_numeric($weight)){
            currency::Output($this->config->item('request_fall'),'重量选项为必填选项!');
        }
        $dealtype=$this->input->post('dealtype',true);//交易类型   1 添加到库存 2 现金
        if($dealtype != 1 && $dealtype != 2){
            currency::Output($this->config->item('request_fall'),'交易类型选项为必填选项!');
        }
        
    }
}