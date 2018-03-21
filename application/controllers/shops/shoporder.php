<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
date_default_timezone_set('Asia/Shanghai');
/**
 * 
 * @author xiaotao
 * 个人中心模块
 */
class  Shoporder extends CI_Controller{
    /**
     * 通话商城订单列表
     */
    function commitorder(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        $sid = $this->input->post('sid',true);
        $price = $this->input->post('price',true);
        if (!is_numeric($sid)||!is_numeric($price)) {
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_add_fall'),'','');
        }
        $this->load->model('shops_model');
        $goodinfo = $this->shops_model->goodinfo($sid);
        if ($goodinfo===false||$goodinfo['0']['number']<=0) {
            currency::Output($this->config->item('request_fall'),'没有货了');
        }
        $goodinfo['0']['property'] = json_decode($goodinfo['0']['property'],true);
        if ($goodinfo['0']['property']['canbuynum']>0) {
            $return = $this->shops_model->gamebuyone($goodinfo['0']['id'],$user_id);
            if($return == false){
                currency::Output($this->config->item('request_fall'),'您已经购买过此商品！','','');
            }
        }
        $returnshow = $insertinfo = $this->checkInfo($goodinfo);
        $goodinfo['0']['otherprice'] = json_decode($goodinfo['0']['otherprice'],true);
        $goodinfo['0']['otherprice']['0']['p'] = $goodinfo['0']['prri'];
        $goodinfo['0']['otherprice']['0']['in'] = $goodinfo['0']['integral'];
        $returnshow['fid'] = $goodinfo['0']['fid'];
        $returnshow['tyid'] = $goodinfo['0']['tyid'];
        if (!isset($goodinfo['0']['otherprice'][$price])) {
            currency::Output($this->config->item('request_fall'),'','','');
        }
        $p = $returnshow['price'] = $goodinfo['0']['otherprice'][$price]['p'];
        $in = $returnshow['inte'] = $goodinfo['0']['otherprice'][$price]['in'];
        if ($in>0) {//需要通花时检测用户的通花是否足够
            $integral = $this->shops_model->getUserInfo($user_id);
            if ($integral['0']['center_integral']<$in) {
                currency::Output($this->config->item('request_fall'),'您的通花不足！','','');
            }
        }
        $returnshow['number'] = $number = $this->create_ordrenumber();
        if ($p>0) {
            $this->load->library('wxsdk/wxpay');
            $info=array(
                'body'=>$goodinfo['0']['name'],
                'orderid'=>$number,
                'moeny'=>($p/100),
                'pro_id'=>$goodinfo['0']['id'],
                'type'=>'NATIVE',
                'notifyurl'=>'http://test.recytl.com/callback/paytest.php'    //要回调的地址
            );
            $orderImgName = $number;
            $result = $this->wxpay->code($orderImgName,$info);
            if ($result==false) {
                currency::Output($this->config->item('request_fall'),'无法生产订单！','','');
            }
            $returnshow['qrimg'] = '/qrcode/goods/'.$orderImgName.'.jpg';
            $insertinfo['record_type'] = 2;//1为微信回收支付  2为微信寄售通支付
        }else{
            $config='<script>if (confirm("确定消耗'.$in.'通花购买")) { Checkpay();};
                    function Checkpay(){$.ajax({type: "POST",url:"/index.php/shops/shoporder/incommit",
                    data:"number='.$number.'",dataType:"json",
                    beforeSend: function(){$("#turn_gif_box").css("display","block");},success: function(data){
                    var response=eval(data);if(response["status"]==request_succ){UrlGoto(response["url"]);}else{alert(response["msg"])}},
                    complete :function(XMLHttpRequest, textStatus){
                    $("#turn_gif_box").css("display","none");},error:function(XMLHttpRequest,textStatus,errorThrown){
                    }});}</script>';
            $returnshow['config'] = $config;
            $insertinfo['record_type'] = 1;//1为微信回收支付  2为微信寄售通支付
        }
        $returnshow['name'] = $goodinfo['0']['name'];
        $insertinfo['record_price'] = $p;
        $insertinfo['record_integral'] = $in;
        $insertinfo['record_payid'] = $number;
        $insertinfo['record_userid'] = $user_id;
        $insertinfo['record_goodid'] = $sid;
        $return = $this->shops_model->addOrder($insertinfo);
        if ($return===false) {
            currency::Output($this->config->item('request_fall'),'订单添加失败','','');
        }
        currency::Output($this->config->item('request_succ'),'订单添加成功','',$returnshow);
    }
    /**
     * 检查提交订单传来的参数
     */
    private function checkInfo($goodinfo){
        $result = array();
        if ($goodinfo['0']['fid']==2) {
            $phone = $this->input->post('mobile',true);
            $name = currency::filter($this->input->post('name',true));
            $province = currency::filter($this->input->post('province',true));
            $city = currency::filter($this->input->post('city',true));
            $area = currency::filter($this->input->post('area',true));
            $adr_detail = currency::filter($this->input->post('adr_detail',true));
            $adresid = $this->input->post('adresid',true);
            if(!preg_match("/^(1[3|4|5|7|8][0-9]{9})$/",$phone)){
                currency::Output($this->config->item('request_fall'),'请填写正确的手机号码','','');
            }
            if (empty($phone)||empty($name)||empty($city)||empty($adr_detail)||!is_numeric($adresid)) {
                currency::Output($this->config->item('request_fall'),'请把地址与信息填写完整！','','');
            }
            $result['record_adress'] = $name.','.$phone.','.$province.$city.$area.$adr_detail;
            $result['record_adressid'] = $adresid;
        }elseif($goodinfo['0']['tyid']==4){
            $phone = $this->input->post('mobile',true);
            if(!preg_match("/^(1[3|4|5|7|8][0-9]{9})$/",$phone)){
                currency::Output($this->config->item('request_fall'),'请填写正确的手机号码','','');
            }
            $l_mobile = substr($phone,0,3);
            $this->config->load('shop',true);//配置项加载
            $operators = $this->config->item('shop');
            $where = $goodinfo['0']['property']['ft'];
            switch ($where) {
                case '1':
                    $re = (in_array($l_mobile, $operators['mobile_operators']['corporation']))?true:false;
                    break;
                case '2':
                    $re = (in_array($l_mobile, $operators['mobile_operators']['unicom']))?true:false;
                    break;
                case '3':
                    $re = (in_array($l_mobile, $operators['mobile_operators']['telecom']))?true:false;
                    break;
                default:
                    return false;
                    break;
            }
            if ($re==false) {
                currency::Output($this->config->item('request_fall'),'您的手机号码无法充值此运营商！','','');
            }
            $result['record_content'] = $phone;
        }elseif($goodinfo['0']['fid']!=1){
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_add_fall'),'','');
        }
        return $result;
    }
    function checkorder(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $number = $this->input->post('number',true);
        if (!is_numeric($number)) {
            currency::Output($this->config->item('request_fall'),'','','');
        }
        $this->load->model('shops_model');
        $result = $this->shops_model->getOrder($number);
        if ($result === false) {
            currency::Output($this->config->item('request_fall'),'','','');
        }
        if ($result['0']['status']==0||$result['0']['status']==-1) {
            currency::Output($this->config->item('request_fall'),'','',$result['0']);
        }else{
            currency::Output($this->config->item('request_succ'),'','',$result['0']);
        }
    }
    /**
     * 
     */
    function  incommit(){
        $number = $this->input->post('number',true);
        if(empty($number) || !is_numeric($number)){
            currency::Output($this->config->item('request_succ'),'请求非法！','','');
        }
        for ($i=0; $i < 4; $i++) { //不成功，再请求，最多四次
            $url = 'http://test.recytl.com/index.php/shop/integral/queryOrder';
            $data = array(
                'number'=>$number,
            );
            $curl = curl_init ();
            curl_setopt($curl,CURLOPT_URL,$url);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
            $return = curl_exec ( $curl );
            curl_close ( $curl );
            $return = json_decode($return,true);
            if ($return['status']==1000) {
                currency::Output($this->config->item('request_succ'),'购买成功！',
                                '/index.php/shops/shopinfo/orderdetail/'.$return['data']['recordid'],'');
                break;
            }
        }
        currency::Output($this->config->item('request_fall'),$return['msg'],'','');
    }
    /**
     *  生成订单订单编号
     * @return string
     */
    function create_ordrenumber(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).rand(1000,9999);
    }
}