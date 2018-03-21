<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author xiaotao
 * 个人中心 model 模块
 */
class center_model extends CI_Model{
    
    
    
    /**
     * 个人中心获取用户信息
     * @param   int   id 用户id
     * @return  成功回去信息返回array结果 | 失败返回false
     */
    function  centerInfo(){
        $this->load->database();
        $sql='select wx_mobile,wx_balance,wx_freeze_balance from h_wxuser where 
              wx_id='.$this->id;
        $query=$this->db->query($sql);
        if($query->num_rows < 1){
            return false;
        }
        $info=$query->result_array();
        $sql_integral='select center_integral from h_wxuser_task where wx_id='.$this->id;
        $query_integral=$this->db->query($sql_integral);
        if($query_integral->num_rows < 1){
            $integral['0']['center_integral']=0;
        }else{
            $integral=$query_integral->result_array();
        }
        $photo=empty($_SESSION['user_img']) ? $this->config->item('center_default_photo') :$_SESSION['user_img'];
        $data=array(
                'photo'=>$photo,
                'name'=>$_SESSION['user_name'],
                'mobile'=>$info['0']['wx_mobile'],
                'balance'=>$info['0']['wx_balance']/100,
                'freeze_balance'=>$info['0']['wx_freeze_balance']/100,
                'integral'=>$integral['0']['center_integral']
        );
        return $data;
    }
    /**
     * 获取订单统计
     * @param  int   id  用户id
     * @return  结果成功获取返回array |失败返回 false
     */
    function orderOverView(){
        $this->load->database();
        //统计正在进项中的订单
        $sql_n='select  count(*) as num  from h_order_nonstandard  where wx_id='.
                $this->id.' and order_orderstatus in(1,2,3)';
        $query_n=$this->db->query($sql_n);
        $result_n=$query_n->result_array();
        $response['norder']=$result_n['0']['num'];
        $sql_y='select  count(*) as num  from h_order_nonstandard  where wx_id='.
                $this->id.' and order_orderstatus = 10';
        $query_y=$this->db->query($sql_y);
        $result_y=$query_y->result_array();
        $response['yorder']=$result_y['0']['num'];
        return $response;
    }
}