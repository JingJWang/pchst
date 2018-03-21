<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
class  Maintain extends CI_Controller {
    
    /**
     * 检测首页成交数据是否异常
     */
    function checkVolume(){
        //发送短信验证码
        $this->load->model('common/msg_model');
        $this->msg_model->mobile='15811310237';
        $this->msg_model->time=date('Y-m-d H:i:s');
        $this->msg_model->msg='首页成交数据异常';
        $this->msg_model->content='出现错误信息';
        $this->msg_model->template='SMS_5037152';
        $response=$this->msg_model->sendWarning();
    }
    /**
     * 定时查询 自动报价任务列表 存在多少未报价的订单
     * 
     */
    function checkTaskOrdre(){
        
        
    }
    
}