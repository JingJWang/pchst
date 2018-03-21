<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quote_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 校验订单状态
     * @param   int   orderid　　订单id
     * @return  成功返回bool | true ,失败返回bool | false
     */
    function  checkOrder($orderid,$userid){
        if(empty($orderid) || !is_numeric($orderid) || !is_numeric($userid)){
            return false;
        }
        $sql='select a.order_ctype,a.order_number,a.order_name,a.order_province,
              a.order_city,a.order_county,a.order_residential_quarters,a.order_jointime as jointime,a.types_id as tyid,
              a.order_orderstatus,b.electronic_oather,b.electronic_img from h_order_nonstandard
              as a left join  h_order_content as b  on a.order_number=b.order_id
              where a.order_number='.$orderid.' and  a.wx_id='.$userid;
        $query=$this->db->query($sql);
        if($query->num_rows() == 0 ){
            return false;
        }
        $data['order']=$query->row_array();
        if (empty($data['order']['tyid'])) {
            $data['order']['img'] = '';
        }else{
            $sql = 'select types_img from h_electronic_types where types_id='.$data['order']['tyid'];//获取订单内容
            $img = $this->db->query($sql);
            if ($img->num_rows>=1) {
                $img = $img->result_array();
                $data['order']['img'] = $img['0']['types_img'];
            }
        }
        return $data;        
    }
    /**
     * 获取报价列表
     */
    function GetScreening($option){
        if (!is_numeric($userid=$_SESSION['user_id'])) {
            return false;
        }
        $where=' b.wx_id ="'.$userid.'" and a.order_id="'.
        $_SESSION['quoteId'].'" and b.order_orderstatus=1 ';
        //是否搜素 选择的服务
        if(!empty($option['option']) ){
           switch ($option['option']){
               case 'd':
                      $where .= ' and  find_in_set("'.'到小区'.'",a.offer_service)';
                   break;
               case 's':
                      $where .= ' and  find_in_set("'.'上门回收'.'",a.offer_service)';
                   break;  
               case 'o':
                      $where .= ' and  find_in_set("'.'快递包邮'.'",a.offer_service)';
                   break;
           }
        }
        //是否搜素认证回收商
        if ($option['auto']!=''){
            if ($option['auto']==1) {
                $where .= ' and  a.offer_coop_auth = 1';
            }elseif($option['auto']==2){
                $where .= ' and  a.offer_coop_auth = 2';
            }elseif($option['auto']==0){
                $where .= ' and  a.offer_coop_auth = 0';
            }
        }
        //是否  排序
        if(!empty($option['price'])){
            $where .= ' order by  a.offer_price  desc ';
        }
        if(!empty($option['distance'])){
            $where .= ' order by a.offer_distance asc ';
        }
        if(!empty($option['evaluation'])){
            $where .= ' order by a.offer_coop_class desc ';
        }
        if(!empty($option['transaction'])){
            $where .= ' order by  a.offer_done_times  desc ';
        }
        $sql='select a.offer_id as offerid,a.order_id as orderid,a.offer_price as
              price,a.offer_service as service,a.offer_distance as distance,
              a.offer_coop_name as cname,a.offer_coop_class as cclass,
              a.offer_coop_auth as cauth,c.statistic_sum as csum,
              a.cooperator_number as number,b.order_name as name  from
              h_cooperator_offer as a left join h_order_nonstandard as b
              on a.order_id = b.order_number left join h_order_statistic as c on
              a.cooperator_number=c.cooperator_number where '.$where;
        $query=$this->db->query($sql);
        if($query->num_rows() == 0 ){
           return array();
        }
        $data=$query->result_array();
        $arr_company=$this->config->item('coop_auth_company');
        foreach ($data as $key=>$val){
            array_key_exists($val['number'],$arr_company) ? 
            $company=''.$arr_company[$val['number']].'': $company=mb_substr($val['cname'],0,1,'utf-8').'师傅';
            $data[$key]['cname']=$company;
            $auto=$this->config->item('cooperator_auth_type');
            $data[$key]['cauth']=$auto[$data[$key]['cauth']];
            $data[$key]['service'] = strpos(',',$val['service']) ? explode(',',$val['service']): array($val['service']);
            $data[$key]['ctype']=in_array($data[$key]['number'],$this->config->item('js_cooplist')) ? 1 : 0;
        }
        return $data;
    }
    /**
     * 查询订单详细信息
     * @param   int    orderid   订单id
     * @param   int    userid    用户id
     * @return  获取订单数据成功时 返回 array 订单信息| 失败返回bool  false
     */
    function  GetOrderInfo($orderid,$userid){
        //查询订单详情
        $sql='select a.order_ctype,a.order_number,a.order_name,a.order_province,a.order_city,a.order_county,
              a.order_residential_quarters,a.order_jointime as jointime,a.types_id as tyid,
              a.order_orderstatus,b.electronic_oather,b.electronic_img from h_order_nonstandard
              as a left join  h_order_content as b  on a.order_number=b.order_id
              where a.order_number='.$orderid.' and  a.wx_id='.$userid;
        $query=$this->db->query($sql);
        if($query->num_rows() == 0 ){
            return false;
        }
        $data['order']=$query->row_array();
        $data['quote']='';
        if (empty($data['order']['tyid'])) {
            $data['order']['img'] = '';
        }else{
            $sql = 'select types_img from h_electronic_types where types_id='.$data['order']['tyid'];//获取订单内容
            $img = $this->db->query($sql);
            if ($img->num_rows>=1) {
                $img = $img->result_array();
                $data['order']['img'] = $img['0']['types_img'];
            }
        }
        //当订单状态为等待报价时
        if($data['order']['order_orderstatus'] == 1){
            $quotesql='select offer_id as id,offer_coop_name as name,offer_price 
                        as price,cooperator_number as number from
                       h_cooperator_offer where order_id="'.$orderid.'"';
            $result=$this->db->query($quotesql);
            if($result->num_rows < 1){
                $data['quote']=0;
            }
            $data['quote']=$result->result_array();
            $data['order']['order_residential_quarters']='';
        }
        if($data['order']['order_orderstatus'] == 2 || $data['order']['order_orderstatus'] == 3
            || $data['order']['order_orderstatus'] == 4 || $data['order']['order_orderstatus'] == 10){
            $order_orderstatus = $data['order']['order_orderstatus']==10?4:$data['order']['order_orderstatus'];
            $sql='select a.offer_id as id,a.offer_coop_name as name,a.offer_distance as distance,
                  a.offer_price as price ,a.offer_money as moeny,a.offer_coop_class as cclass,
                  b.cooperator_mobile as mobile,a.offer_second as second ,a.offer_service as service,
                  a.offer_isagree as isagree,b.cooperator_address as address,
                  b.cooperator_auth_type as auth,b.cooperator_wx as wx,b.cooperator_number as num from  h_cooperator_offer a 
                  left join h_cooperator_info b  on a.cooperator_number=
                  b.cooperator_number where a.order_id="'.$orderid
                  .'" and a.offer_order_status='.$order_orderstatus;
            $result=$this->db->query($sql);
            if($result->num_rows < 1){
                $data['offer']=0;
            }
            $data['offer']=$result->result_array();
            $auto=$this->config->item('cooperator_auth_type');
            $data['offer']['0']['auth']=$auto[$data['offer']['0']['auth']];
        }
        return $data;
    }
    /**
     * 获取产品模型参数
     */
    function geropModel(){
        $sql = 'select model_type,model_alias,model_name,model_type from h_option_model where model_status=1';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 获取某个订单的某个报价的详情
     * @param   int    orderid   订单id
     * @param   int    userid    用户id
     * @param   int    ofid      报价id
     * @return  array   返回数据数组
     */
    function getOneOrder($ofid,$number,$userid){
        $sql='select a.offer_id as offerid,a.order_id as orderid,a.offer_price as
              price,a.offer_service as service,a.offer_distance as distance,
              a.offer_coop_name as cname,a.offer_coop_class as cclass,
              a.offer_coop_auth as cauth,c.statistic_sum as csum,
              a.cooperator_number as number,b.types_id as typeid,b.order_name as name  from
              h_cooperator_offer as a left join h_order_nonstandard as b
              on a.offer_id='.$ofid.' and a.order_id = b.order_number left join h_order_statistic as c on
              a.cooperator_number=c.cooperator_number where b.wx_id ="'.$userid.'" and a.order_id="'.$number.'" and b.order_orderstatus=1 ';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        $result = $result->result_array();
        if(empty($result['0']['typeid'])){
            $result['0']['img'] = '';
        }else{
            $sql = 'select types_img from h_electronic_types where types_id='.$result['0']['typeid'];//获取订单内容
            $img = $this->db->query($sql);
            if ($img->num_rows>=1) {
                $img = $img->result_array();
                $result['0']['img'] = $img['0']['types_img'];
            }
        }
        return $result;
    }
    /**
     * 用户补充订单地址信息
     */
    function saveAddres($addres,$detail,$mobile,$orderid){
        $data=array('order_city'=>$addres['city'],'order_county'=>$addres['area'],'order_mobile'=>$mobile,
              'order_province'=>$addres['pri'],'order_residential_quarters'=>$detail);
        $where=array('order_number'=>$orderid);
        $this->db->update('h_order_nonstandard',$data,$where);
        $up=$this->db->affected_rows();
        if($up == 1){
            return true;
        }
        return false;
    }
    /**
     * 用户选择回收商报价
     * @param   int   offerid  报价id
     * @param   int   orderid  订单id
     * @return  成功返回 bool true | 失败返回 bool false
     */
    function ChoiceQuote($orderid,$offerid){ 
        //校验订单是否  是快递回收
        $sql='select offer_id  from h_cooperator_offer where offer_id="'.$offerid.'" and 
              find_in_set("'.'快递回收'.'",offer_service)';
        $result=$this->db->query($sql);
        //当确认是快递回收  订单状态 改为 等待确认 否则 为 等待交易
        $result->num_rows() > 0 ? $orderstatus = 2 : $orderstatus = 3;
        //修改订单 报价状态             
        $this->db->trans_begin();
        $this->db->update('h_order_nonstandard',array('order_orderstatus'=>$orderstatus,
                'order_updatetime'=>time()),array('order_number'=>$orderid));
        $up_order=$this->db->affected_rows();        
        $this->db->update('h_cooperator_offer',array('offer_order_status'=>$orderstatus,
                'offer_update_time'=>time()),array('offer_id'=>$offerid));   
        $up_offer=$this->db->affected_rows();        
        $this->db->update('h_cooperator_offer',array('offer_status'=>-1,
                'offer_update_time'=>time()),array('order_id'=>$orderid,'offer_order_status'=>1));
        //验证 修改结果       
        if ($this->db->trans_status() === false || $up_order != 1 || $up_offer != 1){
            $this->db->trans_rollback();           
            return false;            
        }else{
            $this->db->trans_commit();
            //查询回收商的编号  发送APP通知
            // $sql='select cooperator_number from  h_cooperator_offer  where offer_id='.$offerid;
            // $query=$this->db->query($sql);
            // $offer=$query->row_array();
            // $this->load->library('vendor/notice');
            // $notice[]=$offer['cooperator_number'];
            // $response=$this->notice->JPush('voice',$notice,'您有报价已经被用户确认!',array("voice"=>"1", "content"=>"22"));
            return true;
        }
    }

    function __destruct(){
        $this->db->close();
    }
}