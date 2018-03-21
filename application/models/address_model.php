<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 个人中心获取用户信息
     * @param   int   id 用户id
     * @return  成功回去信息返回array结果 | 失败返回false
     */
    function  getUAdres($userid){
        $sql = 'select receive_id as id,receive_name as name,receive_phone as phone,receive_province as province,
                receive_city as city,receive_area as area,receive_details as details,receive_status as status 
                from h_wxuser_receiveinfo where user_id='.$userid.' and (receive_status=1 or receive_status=2)';//2未默认地址
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 获取某个地址信息
     * @param      int       adressid         地址的id
     */
    function getOneAdre($adressid){
        $sql = 'select receive_id as id,user_id as uid,receive_name as name,receive_phone as phone,
                receive_city as city,receive_details as details,receive_status as status from h_wxuser_receiveinfo 
                where receive_id='.$adressid.' and (receive_status=1 or receive_status=2)';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 添加地址
     * @param       int          userid       用户的id
     * @param       string       name         收件人姓名
     * @param       int          phone        收件手机号码
     * @param       string       city         城市
     * @param       string       detail       详细地址
     * @param       bool          default      是否默认
     * @param       int          nowDefIid    现在默认地址的id   没有则为NULL
     * @return      bool         正确返回true|错误返回false
     */
    function inaddress($insert,$nowDefIid){
        $insert['receive_jointime'] = $time = time();
        //开启事务
        $this->db->trans_begin();
        if ($nowDefIid!==NULL&&$insert['receive_status']==2) {//修改默认地址
            $result = $this->db->update('h_wxuser_receiveinfo',array('receive_status'=>'1','receive_uptime'=>$time),
                               array('receive_id'=>$nowDefIid));
            if ($result===false||$this->db->affected_rows()!=1) {
                $this->db->trans_rollback();
                return false;
            }
        }
        $result = $this->db->insert('h_wxuser_receiveinfo',$insert);
        $inid = $this->db->insert_id();
        if ($result===false||$this->db->affected_rows()!=1) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return $inid;
    }
    /**
     * 更新某个地址
     * @param       string       name         收件人姓名
     * @param       int          phone        收件手机号码
     * @param       string       city         城市
     * @param       string       detail       详细地址
     * @param       bool         default      是否默认
     * @param       int          adressid     要更新的id
     * @param       int          nowDefIid    现在默认地址的id   没有则为NULL
     * @return      bool         正确返回true|错误返回false
     */
    function upaddress($update,$adressid,$nowDefIid){
        $update['receive_uptime'] = $time = time();
        //开启事务
        $this->db->trans_begin();
        if ($nowDefIid!==NULL&&$update['receive_status']==2) {//修改默认地址
            $result = $this->db->update('h_wxuser_receiveinfo',array('receive_status'=>'1','receive_uptime'=>$time),
                               array('receive_id'=>$nowDefIid));
            if ($result===false||$this->db->affected_rows()!=1) {
                $this->db->trans_rollback();
                return false;
            }
        }
        $result = $this->db->update('h_wxuser_receiveinfo',$update,array('receive_id'=>$adressid));
        if ($result===false||$this->db->affected_rows()!=1) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
    /**
     * 删除某个任务信息
     * @param      int      id      任务id
     */
    function deladdre($id){
        $reuslt = $this->db->update('h_wxuser_receiveinfo',
            array('receive_uptime'=>time(),'receive_status'=>'-1'),array('receive_id'=>$id));
        if ($reuslt===false||$this->db->affected_rows()!=1) {
            return false;
        }
        return true;
    }
    function __destruct(){
        $this->db->close();
    }
}