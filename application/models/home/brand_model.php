<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 获取商品类型品牌
     * @param       int       type       物品类型
     * @param       int       star       开始的页数
     * @return      失败返回false|成功返回数组
     */
    function getBrand($type){
        //判断缓存
        $brands = $this->fromCache('electronic_brand_'.$type);
        if ($brands!==false) {
            return $brands;
        }
        //没有缓存后
        $sql = 'select brand_name as name,brand_id as id,brand_img as img from h_brand 
                where brand_classification='.$type.' and brand_status=1';
        $result = $this->db->query($sql);
        if($result->num_rows<1){
            return false;
        }
        if ($this->cache->link === true) {//添加缓存
            $texts = $this->cache->_redis->set('electronic_brand_'.$type,json_encode($result->result_array()));
        }
        return $result->result_array();
    }
    /**
     * 获取商品列表
     * @param       int       bid       商品的id
     * @param       int       star      开始的页数
     * @param       int       num       要取的个数
     * @return      失败返回false|成功返回数组
     */
    function getShops($bid,$star){
        //判断缓存
       /*  $commodity = $this->fromCache('onebrand_'.$bid.'_'.$star);
        if ($commodity!==false) {
            return $commodity;
        } */
        //没有缓存后
        $sql = 'select types_id as id,types_name as name,types_img as img,types_maxprice as mprice 
                from h_electronic_types where brand_id='.$bid.' and types_status=1 order by types_id desc limit '.$star.',24';
        $result = $this->db->query($sql);
        if($result->num_rows<1){
            return false;
        }
       /*  if ($this->cache->link === true) {//添加缓存
            $texts = $this->cache->_redis->set('onebrand_'.$bid.'_'.$star,json_encode($result->result_array()));
        } */
        return $result->result_array();
    }
    /**
     * 获取此品牌商品的总数
     */
    function getShNum($bid){
        //判断缓存
        $num = $this->fromCache('onebrandNum_'.$bid);
        if ($num!==false) {
            return $num;
        }
        $sql = 'select count(types_id) as allnum from h_electronic_types 
                where brand_id='.$bid.' and types_status=1';
        $result = $this->db->query($sql);
        if($result->num_rows<1){
            return false;
        }
        if ($this->cache->link === true) {//添加缓存
            $texts = $this->cache->_redis->set('onebrandNum_'.$bid,json_encode($result->result_array()));
        }
        return $result->result_array();

    }
    /**
     * 搜索商品
     */
    function seachShop($bids,$text){
        $where = '';
        foreach ($text as $key => $val) {
            $where .= ' and types_name like "%'.$val.'%" ';
        }
        $sql = 'select  types_id as id,types_name as name,types_img as img,types_maxprice as mprice
                from h_electronic_types where brand_id in ('.$bids.') '.$where.' and types_status=1 order by types_id desc';
        $result = $this->db->query($sql);
        if($result->num_rows<1){
            return false;
        }
        return $result->result_array();
    }
    /**
     * 从缓存读取数据
     * @param       string        keyName        要获取值的key的名称
     * @return      正确返回array|错误返回false
     */
    function fromCache($keyName){
        $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link === true) {
            $result = $this->cache->_redis->get($keyName);
            if ($result!==false&&!empty($result)) {
                return json_decode($result,true);
            }else{
                return false;
            }
        }
        return false;
    }
    function __destruct(){
        $this->db->close();
    }
}