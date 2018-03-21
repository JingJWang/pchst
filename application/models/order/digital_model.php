<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
/*
 * 数码模块
 * 提交订单
 */
class digital_model extends CI_Model{
    
    /**
     * 校验当前型号是否存在
     */
    function __construct(){
        parent::__construct();
        $this->load->database();   
    }
    /**
     * 校验当前型号是否存在
     * @param  int   id  型号id
     * @return  array  成功返回array 型号信息 |不存在 返回bool false
     */
    function  getTypeInfo(){
        $sql='select types_name,types_attr,types_img,types_maxprice from h_electronic_types where types_id='.
              $this->id.' and types_status=1';
        $query=$this->db->query($sql);
        if($query->num_rows < 1){
            return false;
        }
        $result=$query->result_array();
        return $result;
    }
    /**
     * 读取属性信息
     * @param  int  id   产品id
     * @return  成功获取返回 array 结果 | 失败返回bool false
     */
    function getOption(){
        $model_sql='select model_model as model ,model_type as type,model_alias as alias,
                model_logic as logic,model_name as name from h_option_model where model_status=1';
        $model_query=$this->db->query($model_sql);
        if($model_query === false || $model_query->num_rows < 1){
            return false;
        }
        $model=$model_query->result_array();
        $info_sql='select info_id as id ,info_info as info from h_option_info where info_status=1';
        $info_query=$this->db->query($info_sql);
        if($info_query === false || $info_query->num_rows < 1){
            return false;
        }
        $info=$info_query->result_array();
        $response=array('model'=>$model,'info'=>$info);
        return $response;
    }
    /**
     * 获取详细的参数内容
     * @return  成功返回array内容 | 失败返回 false
     */
    function GetOptionInfo(){
        $info_sql='select info_id as id ,info_info as info from
                h_option_info where info_status=1';
        $info_query=$this->db->query($info_sql);
        if($info_query === false || $info_query->num_rows < 1){
            return false;
        }
        $info=$info_query->result_array();
        return $info;
    }
    /**
     * 根据产品型号获取产品信息
     * @param  int  typeid  产品型号
     * @return 成功  array | 遇到错误 bool false
     */
    function getProInfo(){
        $sql='select a.product_name as pname,a.product_id as pid,b.brand_name
              as bname,b.brand_id as bid,c.types_name as cname ,c.types_id as cid
              from h_order_product as a left join h_brand as b on a.product_id=
               b.brand_classification left join  h_electronic_types as c on b.brand_id=
               c.brand_id where c.types_id='.$this->typeid.' and c.types_status=1';
        $query=$this->db->query($sql);
        if($query === false || $query->num_rows< 1){
            return false;
        }
        $data=$query->result_array();
        return $data;
    }
    /**
     * 添加自动报价订单
     * @param  int  id          型号id
     * @param  int  latitude    纬度
     * @param  int  longitude   经度
     */
    function  savePlanOrder(){
        //创建订单信息
        $this->number=currency::create_ordrenumber();
        $sql='insert into h_order_nonstandard(wx_id, order_name, order_ctype,
        order_ftype,order_orderstatus,order_isused, order_img,order_jointime,
        order_status, order_number, wx_openid,order_submittime,types_id)value('.
        $this->userid.',"'. $this->typename.'", '.$this->pid.',1,"1","1"," ",'.
        time().', 1, "'.$this->number.'","'.$this->openid.'","'.time().'",'.$this->id.')';
        $this->db->trans_begin();
        $query=$this->db->query($sql);
        $order=$this->db->affected_rows();
        //保存订单属性
        $this->db->insert('h_order_content',
                array(
                        'order_id'=>$this->number,
                        'electronic_oather'=>$this->attr,
                        'electronic_jointime'=>time(),
                        'electronic_status'=>1)
        );
        $content=$this->db->affected_rows();
        //添加自动报价任务
        $this->db->insert('h_quote_task',array(
                'plan_openid'=>$this->openid,'plan_content'=>$this->plan,
                'order_number'=>$this->number,'plan_jointime'=>time(),
                'plan_mobile'=>$this->mobile,'type_id'=>$this->id,
                'plan_status'=>-1,'type_name'=>$this->typename
        ));
        $plan=$this->db->affected_rows();
        if($this->db->trans_status() && $content == 1 && $order == 1 && $plan == 1){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    
    }
    
    /**
     *校验当前用户本周报单数量是否超过限制
     *@param  int  mobile 手机号码
     *@param  int  userid 用户id
     *@return bool 校验通过 返回true | 否则返回false
     */
    function checkNum(){
    	$starts=mktime(0,0,0,date('m'),date('d'),date('Y'));
    	$ends=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
    	//校验当前是否达到报单限制
    	$sql='select order_id from h_order_nonstandard where
              wx_id='.$this->userid.' and order_jointime > '.
              $starts.' and order_jointime < '.$ends;
    	$num_result=$this->db->query($sql); 
    	//当超过限制数量的时候  返回提示信息
    	if($num_result->num_rows() >= 5){
    		return true;
    	}else{
    		return false;
    	}
    }
}