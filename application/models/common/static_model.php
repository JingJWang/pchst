<?php
class  static_model extends  CI_Model{  
    
    
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 首页读取成交额,交易记录
     */
    function indexVolume(){
      /* $this->load->library('common/cache');
        $config=$this->config->item('redis_config_aliyun');
        $redis=$this->cache->getRedis($config);
        //读取redis中的值
        $this->cache->key='index_data_volume';
        $cache=$this->cache->existsKey();
        if($cache !== false && !empty($cache)){
            $response=json_decode($cache,true);
            return $response;
        }  */
        //当redis中不存在值 读取数据库中的记录
        $sql='select data_id,data_content from h_system_data where data_starttime > '.
                strtotime(date('Y-m-d')).' and data_status=0';
        $query=$this->db->query($sql);
        $row=$this->db->affected_rows();
        if($query ===false || $row < 1){
            $response=array('volume'=>'结算中','number'=>'结算中');
            return $response;
        }
        $result=$query->result_array();
        if($query ===false || $row < 1){
            $response=array('volume'=>'结算中','number'=>'结算中');
            return $response;
        }
       //保存记录结果写入redis
       /*  $this->cache->key='index_data_volume';
        $this->cache->val=$result['0']['data_content'];
        $this->cache->cover=true;
        $this->cache->expire=86400;
        $cache=$this->cache->setKey();
        $this->db->update('h_system_data',array('data_uptime'=>time(),'data_status'=>-1),
                array('data_id'=>$result['0']['data_id'])); 
        $response=json_decode($result['0']['data_content'],true); */
        return $response;
    }
}