<?php
/*
 * 数码订单model
 */
class comm_model extends CI_Model{
    
    //加载db
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //佣金结算记录添加
    function insert()
    {
    	$data = array(
    			'settle_ready_money' =>$this->rmoney,
    			'settle_surplus_money' => $this->smoney,
    			'settle_person' => $this->person,
    			'settle_people' =>$this->people
    	);
    	$this->db->insert('h_settle',$data);
    	$content=$this->db->affected_rows();
    	if($content == 1){
    		return true;
    	}else{
    		return false;
    	}
    }
    //查询sql语句
    function select(){
        //开始位置
     	$start =($this->page-1)*$this->num;
    	$sql ='select settle_id as sid,settle_ready_money as rmoney,settle_surplus_money as smoney,settle_person as person,settle_people as people
    		from h_settle where settle_person='.$this->person;
    	$count=$this->db->query($sql);
    	if($start >= 0){
    		$sql .=' limit '. $start.','.$this->num;
    	}
    	$query=$this->db->query($sql);
		if($query->num_rows<0) {
	    	return false;
	 	}
	 	$result['now'] = $this->page;
        $returnList = $query->result_array();
        $return['list']=$returnList;
        $return['num']= ceil($count->num_rows/$this->num);
        return $return;
    }
}  