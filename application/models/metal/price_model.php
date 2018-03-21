<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class price_model extends  CI_Model{
    
    /**
     * 调用聚合数据的接口获取黄金交易数据
     */
    function  jhMetalData(){
        $this->load->library('common/cache');
        $cacheOption=$this->config->item('redis_config_aliyun');
        $redis=$this->cache->getRedis($cacheOption);
        //校验redis是否存在缓存结果
        $get=$redis->get('metalprice');
        if($get !== false){
            return $get;
        }
        //请求聚合数据接口获取黄金交易数据
        $uri='http://web.juhe.cn:8080/finance/gold/bankgold?key='.$this->config->item('jhdata_key');
        $resp=currency::curlGet($uri);
        $metal=json_decode($resp,true);
        if( 200 != $metal['resultcode']){
            return false;
        }
        //连接缓存redis 缓存结果数据
        $set=$redis->set('metalprice',json_encode($metal['result']['0']));
        $expire=$redis->expire('metalprice',3600);
        if($set && $expire){
           return $get;
        }else{
           return false;
        }
    }
}