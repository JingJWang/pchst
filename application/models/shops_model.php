<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shops_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 获取主页的信息
     */
    function getIndexInfo(){
        $sql = 'select goods_name as name,goods_typeid as tyid,goods_img as img,goods_ppri as prri,goods_id as id,
                goods_integral as integral,goods_number as gnumber,goods_property as property,goods_sellnum as sellnum 
                from h_shop_goods where (goods_pshow=1 or goods_pshow=3) and goods_status=1';
        $goods = $this->db->query($sql);
        if ($goods->num_rows<1||$goods==false) {
            return false;
        }
        $goods = $goods->result_array();
        return $goods;
    }
    /**
     * 获取所有分类
     */
    function getTypes(){
        $sql = 'select type_id as id,type_name as name,type_fid as fid from h_shop_type where type_status=1 order by type_sort asc';
        $types = $this->db->query($sql);
        if ($types->num_rows<1||$types==false) {
            return false;
        }
        $types = $types->result_array();
        return $types;
    }
    /**
     * 获取某个类型
     */
    function getOneType($id){
        $sql = 'select type_attributes,type_name,type_fid from h_shop_type where type_id='.$id.' and type_status=1';
        $return = $this->db->query($sql);
        if ($return->num_rows<1||$return==false) {
            return false;
        }
        return $return->result_array();
    }
    /**
     * 获取某个类型下的所有商品
     */
    function getTypeGood($where){
        $sql = 'select goods_id as id,goods_property as property,goods_name as name,goods_sellnum as sellnum,goods_number as gnumber,
                goods_img as img,goods_ppri as ppri from h_shop_goods where '.$where; 
        $return = $this->db->query($sql);
        if ($return->num_rows<1||$return==false) {
            return false;
        }
        return $return->result_array();
    }
    /**
     * 获取单个商品信息
     */ 
    function getOneInfo($id){
        $sql = 'select a.goods_name as name,a.goods_id as id,a.goods_typeid as tyid,a.goods_imgs as imgs,a.goods_ppri as prri,
                a.goods_integral as integral,a.goods_property as property,a.goods_attributes as attri,
                a.goods_content as content,b.type_attributes as battri,b.type_name as tname from h_shop_goods as a left join h_shop_type as b
                on a.goods_typeid=b.type_id where a.goods_id='.$id.' and a.goods_status=1';
        $good = $this->db->query($sql);
        if ($good->num_rows<1||$good==false) {
            return false;
        }
        return $good->result_array();
    }
    /**
     * 获取单个商品简要信息
     */
    function goodinfo($id){
        $sql = 'select a.goods_name as name,a.goods_id as id,a.goods_typeid as tyid,a.goods_img as img,a.goods_number as number,
                a.goods_ppri as prri,a.goods_otherprice as otherprice,a.goods_integral as integral,a.goods_property as property,
                b.type_name as tname,b.type_fid as fid from h_shop_goods as a left join h_shop_type as b
                on a.goods_typeid=b.type_id where a.goods_id='.$id.' and a.goods_status=1';
        $good = $this->db->query($sql);
        if ($good->num_rows<1||$good==false) {
            return false;
        }
        return $good->result_array();
    }
    /**
     * 获取用户订单
     * @param   int   uid   用户的id
     */
    function getUserList($uid){
        $sql='SELECT goods_name as name,goods_img as img,record_jointime as jointime,record_id as id,record_payid as pid,
             record_price as pri,record_integral as integral,record_content as content,record_status as status FROM  h_shop_record as a 
             LEFT JOIN h_shop_goods as  b ON a.record_goodid = b.goods_id WHERE 
             record_userid = '.$uid.' and (a.record_status=1 or a.record_status=2) order by record_jointime desc';
        $result=$this->db->query($sql);
        if($result->num_rows < 1){
            $this->msg='当前没有成交记录';
            return false;
        }
        $data=$result->result_array();
        return $data;
    }
    /**
     * 获取某个订单详情
     * @param   int   uid   用户的id
     * @param   int   $rid  订单的id
     */
    function getOrderDetail($rid,$uid){
        $sql = 'select  a.record_content as code,a.record_price as price,a.record_integral as aintegral,
            a.record_jointime as jointime,a.record_status as status,a.record_payid as pid,a.record_adress as adress,
            b.goods_img as img,b.goods_ppri as ppri,b.goods_integral as integral,b.goods_typeid as tid,
            b.goods_name as name,b.goods_expire as expire,c.type_fid as fid from h_shop_record a 
            left join h_shop_goods b on a.record_goodid=b.goods_id left join h_shop_type as c on b.goods_typeid=c.type_id where 
            a.record_id="'.$rid.'" and   a.record_userid='.$uid;
        $result=$this->db->query($sql);
        if($result->num_rows < 1){
            $this->msg='没有此订单';
            return false;
        }
        $data=$result->result_array();
        return $data;
    }
    /**
     * 提交订单
     * @param   array   要插入的信息
     */
    function addOrder($insert){
        $insert['record_jointime'] = time();
        $insert['record_status'] = 0;
        $result = $this->db->insert('h_shop_record',$insert);
        if ($result===false||$this->db->affected_rows()!=1) {
            return false;
        }
        return true;
    }
    /**
     * 搜索商品
     * @param       array       text        要搜索的文字
     */
    function searchShops($text,$order){
        $where = '';
        foreach ($text as $k => $v) {
            $where .= ' and goods_name like "%'.$v.'%"';
        }
        $sql = 'select goods_id as id,goods_typeid as tyid,goods_name as name,goods_img as img,goods_opri 
                as opri,goods_ppri as ppri,goods_integral as integral,goods_property as property,goods_sellnum as selln from 
                h_shop_goods where goods_status=1 '.$where.' '.$order;
        $result = $this->db->query($sql);
        if ($result===false||$this->db->affected_rows()<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 获取用户的信息判断通花是否足够
     * @param       int         userid          用户的id
     * @return      array       返回通花数量
     */
    function getUserInfo($userid){
        $sql = 'select center_integral from h_wxuser_task where wx_id='.$userid.' and center_status=1';
        $result = $this->db->query($sql);
        if ($result===false||$this->db->affected_rows()<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 检查订单
     */
    function getOrder($number){
        $sql = 'select record_status as status,record_id as id from h_shop_record where record_payid='.$number;
        $result = $this->db->query($sql);    
        if ($result->num_rows<1) {
            return false;
        }
        $return = $result->result_array();
        return $return;
    }
    /**
     * 游戏只能买一个
     */
    function gamebuyone($id,$userid){
        $sql = 'select record_id from h_shop_record where record_goodid='.$id.' and record_userid='.$userid.' and (record_status=1 or record_status=2)';
        $result = $this->db->query($sql);
        if ($result->num_rows>=1&&$result!=false) {
           return false;
        }
        return true;
    }
    function __destruct(){
        $this->db->close();
    }
}