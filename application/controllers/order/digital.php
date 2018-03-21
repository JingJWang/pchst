<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
header('Content-type:text/html;charset=utf-8');
/* 
 * 数码模块
 * 提交订单
 */
class digital extends  CI_Controller{
    
    
    /**
     * 读取当前型号属性信息
     * @param   int  id 型号id
     */
    function option() {
        $id=$this->input->get('id',true);
        if(!is_numeric($id)){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
        }
        //读取当前的数码型号
        $this->load->model('order/digital_model');
        $this->digital_model->id=$id;
        $type=$this->digital_model->getTypeInfo();
        if(false === $type){
            currency::Output($this->config->item('request_fall'),$this->lang->line('commom_existent_fall'));
        }
        //读取型号属性
        $option=$this->digital_model->getOption();
        $sel=json_decode($type['0']['types_attr'],true);
        unset($type['0']['types_attr']);
        $model=array();
        foreach ($option['model'] as $k=>$v){
            $model[$v['alias']]=array('name'=>$v['name'],'model'=>$v['model'],
                    'type'=>$v['type']
            );
        }
        $info=array();
        foreach ($option['info'] as $k=>$v){
            $info[$v['id']]=$v['info'];
        }
        $common_one=array();
        $common=array();
        $other=array();
        $style_one=array();
        $style=array();
        $common_flag=1;
        $style_flag=1;
        foreach ($sel as $k=>$v){
            foreach ($v as $i=>$n){
                $temp=str_replace(array('[',']'),array('',''),$n);
                $sel[$k][$i]=$temp;
            }
            switch ($model[$k]['type']){
                case '0':
                    if (1 == $common_flag){
                        $common_one[$k]=$sel[$k];
                    }else{
                        $common[$k]=$sel[$k];
                    }
                    $common_flag++ ;
                    break;
                case '3':
                    $other[$k]=$sel[$k];
                    break;
                default:                   
                    if (1 == $style_flag){
                         $style_one[$k]=$sel[$k];
                    }else{
                         $style[$k]=$sel[$k];
                    }
                    $style_flag++;
                    break;
            }
        }
        $user=currency::getUser();
        //读取品牌型号
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('common_one',$common_one);
        $smarty->assign('common',$common);
        $smarty->assign('goodsInfo',$type);
        $smarty->assign('other',$other);
        $smarty->assign('style_one',$style_one);
        $smarty->assign('style',$style);
        $smarty->assign('top',$user);
        $smarty->assign('header',array('sign'=>'mobile'));
        $smarty->assign('model',$model);
        $smarty->assign('info',$info);
        $smarty->assign('top',$user);
        $smarty->assign('seo',$seo);
        $smarty->assign('foots',$texts);
        $smarty->display('order/option.html');
    }
    /**
     * 提交当前订单
     * @param  int   id  产品id
     * @param  
     */
    function submit(){
        $option=$this->input->post();
        $id=$option['id'];
        if(!is_numeric($id)){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
        }  
        //校验是否已经登录
        $login=currency::checkOnline();
        if($login){
            currency::getUser();
        }else{
            //提交的信息存入临时会话
            $_SESSION['submit_ordre']=json_encode($this->input->post());
            //当前用户没注册跳转页面 
            $_SESSION['user_goback']='/index.php/order/digital/submit';
            $method=$this->input->is_ajax_request();
            $url='/index.php/user/login?returnUrl='.urlencode('/index.php/order/digital/submit');
            1 == $method ? currency::Output($this->config->item('request_fall'),'',$url):''; 
        }
        //校验传递的属性信息是否正确
        $result=$this->handleData($option);
       
        //获取当前的品牌  型号 分类信息
        $this->load->model('order/digital_model');
        $this->digital_model->typeid=$id;
        $proinfo=$this->digital_model->getProInfo();
        if($proinfo === false){
            currency::Output($this->config->item('request_fall'),$this->lang->line('commom_request_fall'));
        }
        //校验当前用户本周报单是否超过限制
        $this->digital_model->mobile=$_SESSION['user_openid'];
        $this->digital_model->userid=$_SESSION['user_id'];
        $nums=$this->digital_model->checkNum();
        if($nums){
        	currency::Output($this->config->item('request_fall'),'今天报单数量已经超过限制!');
        }else{
        	//添加订单
        	$this->digital_model->id=$option['id'];
        	$this->digital_model->typename=$proinfo['0']['cname'];
        	$this->digital_model->pid=$proinfo['0']['pid'];
        	$this->digital_model->mobile=$_SESSION['user_mobile'];
        	$this->digital_model->openid=$_SESSION['user_openid'];
        	$this->digital_model->userid=$_SESSION['user_id'];
        	$this->digital_model->attr=json_encode($result['order']);
        	$this->digital_model->plan=json_encode($result['plan']);
        	$res=$this->digital_model->savePlanOrder();
        	if($res){
        		$url='/index.php/order/quote/ViewQuote?id='.base64_encode($this->digital_model->number);
        		currency::Output($this->config->item('request_succ'),'',$url);
        	}else{
        		currency::Output($this->config->item('request_fall'),$this->lang->line('digital_submit_fall'));
        	}
        }
        
    }
    /**
     * 处理自动报价的数据
     * @param   array  data 报价数据
     * @return  成功返回array | 失败输出 json  失败原因
     */
    function handleData($data){  
        if(empty($data)){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
        }else{
            unset($data['id']);
        }
        //去除数组中为空的选项
        array_filter($data);        
        //校验是否存在 多选
        if(array_key_exists('other',$data)){
            $other=$data['other'];
            unset($data['other']);
        }
        //校验参数
        $attr=array();
        //校验请求的参数是否整数
        foreach ($data as $k=>$v){
            if(!is_numeric($v)){
                currency::Output($this->config->item('request_fall'),$this->lang->line('digital_option_format'));
            }else{
                $attr[$k]=$v;
            }
        }
        //校验时候存在多选参数 存在转换成数组
        $other_temp=currency::safe_replace($other);
        if(isset($other_temp) && empty($other_temp) === false){
            $sre_other=currency::safe_replace($other_temp);
            if(!is_numeric($other_temp)){
                currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
            }
            $other=str_replace(array(' ','[',']'),array('','',''),$other);
            $other=trim($other,',');
            $other=explode(',',$other);
        }
        //获取参数内容
        $this->load->model('order/digital_model');
        $info=$this->digital_model->GetOptionInfo();
        if(!$info){
            currency::Output($this->config->item('request_fall'),$this->lang->line('digital_submit_option'));
        }
        //转换参数内容数据格式
        $content=array();
        foreach ($info as $k=>$v){
            $content[$v['id']]=$v['info'];
        }
        //获取用于自动报价的参数
        $attrinfo=array();
        foreach ($attr as $k=>$v){
            if(!array_key_exists($v,$content)){
                currency::Output($this->config->item('request_fall'),$this->lang->line('commom_request_fall'));
            }
            $attrinfo[$k]=$content[$v];
        }   
        $attr['other']=$other;
        $temp_str='';
        //获取用于订单详情的内容
        if(is_array($other)){
            foreach ($other as $k=>$v){
                if(!array_key_exists($v,$content)){
                    currency::Output($this->config->item('request_fall'),$this->lang->line('commom_request_fall'));
                }
                $temp_str.= $content[$v].',';
            }
            $attrinfo['other']=trim($temp_str,',');
        }else{
            $attrinfo['other']='';
        }
        $response=array('order'=>$attrinfo,'plan'=>$attr);
        return $response;
    }
}