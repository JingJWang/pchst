<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 获取成交的订单
     *//**
     * 订单列表-----查看待交易的订单
     * @param    int    option    订单状态
     * @param    data             返回查询订单数据
     * 
     * 订单状态(-2)订单未完成     (-1)订单被取消 
     *       (1) 在等待报价  
     *       (2) 确定报价         (3) 待交易状态  
     *       (4) 报价结束         (10)为已成交状态
     */
    function GetOrderList($userid,$status){
        if($status == 1){
            $sql='select  a.order_number as number,a.order_id,FROM_UNIXTIME(a.order_jointime,
                 "%Y-%m-%d %H:%i:%s") as jtime,a.order_evaluation as
                 evaluation,a.order_name as name,a.order_orderstatus as status ,
                 a.order_bid_price as price,c.cooperator_name as coopname,
                 c.cooperator_mobile as coopmobile,FROM_UNIXTIME(a.ordre_dealtime,"%Y-%m-%d %H:%i:%s")as dealtime,
                 d.cancel_remark as remark ,d.cancel_reason as 
                 reason,FROM_UNIXTIME(d.cancel_jointime,"%Y-%m-%d %H:%i:%s") as
                 cantime from  h_order_nonstandard as a left join  h_cooperator_offer
                 as b on a.order_number=b.order_id left join h_cooperator_info as c on
                 b.cooperator_number=c.cooperator_number left join h_order_cancel
                 as d  on a.order_number=d.order_id  where wx_id="'.$userid.'" 
                 and  (order_orderstatus=-1 or order_orderstatus=10) and a.order_status = 1 
                 group by b.order_id  order by a.ordre_dealtime desc';
            $query=$this->db->query($sql);
            if($query->num_rows() < 1){
                return  false;
            }
            $data=$query->result_array();
            $httpurl='/index.php/nonstandard/wxuser/ViewEvaluation?oid=';
            foreach ($data as $k=>$v){
                $data[$k]['coopname']=mb_substr($data[$k]['coopname'],0,1).'师傅';
                $data[$k]['dealtime']=empty($data[$k]['dealtime']) || $data[$k]['dealtime'] == '1970-01-01 08:00:00' ? '': $data[$k]['dealtime'];
                $data[$k]['jtime']=empty($data[$k]['jtime']) || $data[$k]['jtime'] == '1970-01-01 08:00:00' ? '': $data[$k]['jtime'];
                $data[$k]['remark']=empty($data[$k]['remark']) ? ' ':trim($data[$k]['remark'],',');
                $url=$data[$k]['status']==10 ? $httpurl.$data[$k]['number'].'&type=e' : $httpurl.$data[$k]['number'].'&type=q';
                $data[$k]['evaluation']= empty($data[$k]['evaluation']) ? $url : '';
            }
             return $data;
        }
        if($status == 2){
            $sql='select order_name as name ,FROM_UNIXTIME(order_jointime,
                 "%Y-%m-%d %H:%i:%s") as time,count(b.offer_id) as offer,
                 order_number as  number,a.order_orderstatus as status from 
                 h_order_nonstandard  a  left join  h_cooperator_offer  b  
                 on a.order_number=b.order_id  where  wx_id="'.$userid.'" 
                 and a.order_status=1  and a.order_orderstatus != 10 and 
                 a.order_orderstatus!= -1 and a.order_orderstatus != -2 
                  and a.order_orderstatus != 4
                 GROUP BY a.order_number order by a.order_jointime desc ';           
           $query=$this->db->query($sql);
           if($query->num_rows() < 1){
               return  false;
           }
           $data=$query->result_array();
           foreach ($data as $k=>$v){               
               switch ($data[$k]['status']){
                   case '1':
                       $data[$k]['info']='/index.php/order/quote/ViewOrderInfo?id='.$v['number'];
                       $data[$k]['perimit']='/index.php/order/quote/ViewQuote?id='.$v['number'];
                       $data[$k]['status']='报价中';
                       $data[$k]['flag']='a';
                       break;
                   case '3':
                       $data[$k]['info']='/index.php/order/quote/ViewOrderInfo?id='.$v['number'];
                       $data[$k]['status']='待交易';
                       $data[$k]['flag']='b';
                       break;
                   case '2':
                       $data[$k]['info']='/index.php/order/quote/ViewOrderInfo?id='.$v['number'];
                       $data[$k]['status']='待交易';
                       $data[$k]['flag']='b';
                       break;
                   case '4':
                       $data[$k]['info']='/index.php/order/quote/ViewOrderInfo?id='.$v['number'];
                       $data[$k]['perimit']='/index.php/order/quote/ViewQuote?id='.$v['number'];
                       $data[$k]['status']='报价结束';
                       $data[$k]['flag']='c';
                       break;
                   case '-2':
                       $data[$k]['perimit']='/index.php/nonstandard/order/EditOrderAttr?id='.$v['number'];
                       $data[$k]['status']='待提交';
                       $data[$k]['flag']='d';
                       break;
               } 
           }  
           return $data;
        }
        return $data;
    }
    function __destruct(){
        $this->db->close();
    }
}