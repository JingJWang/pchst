<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trans_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    //获取推广客户的总数 1总代2二级管理员3推广员
    function getTransUser(){
    	//获取推广的用户数量+搜索条件
    	$where=' where wx_status=1 and transuser_invitation!=""';
    	if(isset($this->starttime)){
    		$where .=' and c.wx_regtime>="'.$this->starttime.'"';
    	}
    	if(isset($this->endtime)){
    		$where .=' and c.wx_regtime<="'.$this->endtime.'"';
    	}
    	switch ($this->tag){
    		case '1':
    			$sql='select c.wx_id from  (select a.promoter_invitation from h_promoter_user as a left join h_trans_user as b on a.trans_id = 
    				b.trans_id where b.trans_pid ='.$this->id.') as d left join h_wxuser as c on c.transuser_invitation = d.promoter_invitation'.$where;
    			break;
    		case '2':
    			$sql='select a.wx_id as id from h_wxuser a left join h_promoter_user as b on a.transuser_invitation = 
    				b.promoter_invitation '.$where.'  and b.trans_id ='.$this->id;
    			break;
    		case '3':
    			$sql='select a.wx_id as id from h_wxuser a left join h_promoter_user b on a.transuser_invitation=
    				b.promoter_invitation '.$where.' and a.transuser_invitation ="'.$this->invitation.'"';
    			break;
    	}
    	$query = $this->db->query($sql);
     	$result['count']=$query->num_rows;
    	$result['list'] = $query->result_array();
    	return $result;
    }
    //获取推广客户所获得的总佣金数
    function getTransMoney(){
    	switch ($this->tag){
    		case '1':
    			$sql='select sum(royalty_comm_sum) as royalty_comm_sum from h_royalty f left join 
						(select e.wx_mobile,d.trans_pid from h_wxuser e left join
						(select b.promoter_invitation,c.trans_pid from h_promoter_user 
						as b left join h_trans_user as c on c.trans_id =b.trans_id 
						where c.trans_pid="'.$this->id.'") as d on e.transuser_invitation = 
						d.promoter_invitation where d.trans_pid="'.$this->id.'") as e on 
						e.wx_mobile=f.royalty_mobile where e.trans_pid="'.$this->id.'"';
    			break;
    		case '2':
    			$sql='select royalty_comm_sum,d.trans_proportion from h_royalty f left join (select e.wx_mobile,c.trans_proportion,c.promoter_invitation
    				from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation from h_promoter_user a left join h_trans_user b on
    				a.trans_id = b.trans_id where a.trans_id="'.$this->id.'")as c on e.transuser_invitation = c.promoter_invitation) as d
    				on d.wx_mobile=f.royalty_mobile';
    			break;
    		case '3':
    			$sql='select royalty_comm_sum,d.trans_proportion,d.promoter_proportion from h_royalty f left join (select e.wx_mobile,c.trans_proportion,
    				c.promoter_invitation,c.promoter_proportion from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
    				a.promoter_proportion from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where a.trans_id="'.$this->pid.'")
    				c on e.transuser_invitation = c.promoter_invitation) as d on d.wx_mobile=f.royalty_mobile';
    			break;
    			default: return false;
    	}
    	$query = $this->db->query($sql);
    	$result = $query->result_array();
    	return $result;
    }
    //查询 寄售 type=3 回收type=1 销售type=2 的相关数据 tag=1总代tag=2二级代理商 tag=3推广员
    function selectData(){ 
    	$where ='';
    	$start =($this->page-1)*$this->num;
    	if($start >= 0){
    		$limit=' limit '. $start.','.$this->num;
    	}else{
    		$limit='';
    	}
    	//搜索日期获取数据
    	if(!empty($this->starttime)){
    		$where =' and royalty_order_time >= "'.$this->starttime.'"';
    	}
		if(!empty($this->endtime)){
    		$where .=' and royalty_order_time <= "'.$this->endtime.'"';
    	}
    	switch ($this->type){
    		case '1':
    			switch ($this->tag){
    				case '1':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,ifnull(royalty_comm_sum,0) as csum,
    							royalty_type from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,
    							c.promoter_proportion,c.trans_pid from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
    							a.promoter_proportion,b.trans_pid from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id 
    							where b.trans_pid='.$this->id.') c on e.transuser_invitation = c.promoter_invitation where e.transuser_invitation!="" 
    							and c.trans_pid='.$this->id.') as d on d.wx_mobile=f.royalty_mobile where royalty_type like "1%" and 
    							d.trans_pid='.$this->id.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum),0) as sum from h_royalty f left join (
									select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion,c.trans_pid
									from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,a.promoter_proportion ,b.trans_pid
									from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where b.trans_pid='.$this->id.') 
									c on e.transuser_invitation = c.promoter_invitation 
									where e.transuser_invitation!="" and c.trans_pid='.$this->id.' ) as d on d.wx_mobile=f.royalty_mobile where 
									royalty_type like "1%" and d.trans_pid='.$this->id.$where;
    					break;
    				case '2':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,
    							d.trans_proportion as tportion from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,
    							c.promoter_invitation,c.trans_id from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
    							a.trans_id from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->id.')as c 
								on e.transuser_invitation = c.promoter_invitation where e.transuser_invitation!="" and c.trans_id='.$this->id.') as d 
								on d.wx_mobile=f.royalty_mobile where royalty_type like "1%" and d.trans_id='.$this->id.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,sum(royalty_comm_sum*(d.trans_proportion/100))as sum  from  h_royalty f 
									left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.trans_id from h_wxuser e 
									left join (select b.trans_proportion,a.promoter_invitation,a.trans_id from h_promoter_user a 
									left join h_trans_user b on a.trans_id = b.trans_id where b.trans_id='.$this->id.')as c 
									on e.transuser_invitation = c.promoter_invitation  where e.transuser_invitation!="" and c.trans_id='.$this->id.') as d 
									on d.wx_mobile=f.royalty_mobile where royalty_type like "1%" and d.trans_id='.$this->id.$where;
    					break;
    				case '3':
    					 $sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,d.trans_proportion as tprotion,
								d.promoter_proportion as pprotion,d.promoter_invitation as pinvition from h_royalty f left join (select e.wx_mobile,
								c.trans_proportion,c.promoter_invitation,c.promoter_proportion from h_wxuser e left join (
								select b.trans_proportion,a.promoter_invitation,a.promoter_proportion from h_promoter_user a 
								left join h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->pid.') c on 
								e.transuser_invitation = c.promoter_invitation where promoter_invitation="'.$this->invitation.'") as d 
								on d.wx_mobile=f.royalty_mobile where royalty_type like "1%" and d.promoter_invitation="'.
    							$this->invitation.'"'.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum*(d.trans_proportion/100)*(d.promoter_proportion/100)),0)as sum 
									from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,
									c.promoter_proportion from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
									a.promoter_proportion from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id 
									where a.trans_id='.$this->pid.') c on e.transuser_invitation = c.promoter_invitation where 
									promoter_invitation="'.$this->invitation.'") as d on d.wx_mobile=f.royalty_mobile 
									where royalty_type like "1%" and d.promoter_invitation="'.$this->invitation.'"'.$where;
    					break;
    			}
    			break;
    		case '2':
    			switch ($this->tag){
    				case '1':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,ifnull(royalty_comm_sum,0) as csum,
    							royalty_type as rtype from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,
    							c.promoter_proportion,c.trans_pid from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
    							a.promoter_proportion,b.trans_pid from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id 
    							where b.trans_pid='.$this->id.') c on e.transuser_invitation = c.promoter_invitation where 
    							e.transuser_invitation!="" and c.trans_pid='.$this->id.') as d on d.wx_mobile=f.royalty_mobile where 
    							royalty_type like "2%" and d.trans_pid='.$this->id.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum),0) as sum from h_royalty f left join (
									select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion,c.trans_pid
									from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,a.promoter_proportion ,b.trans_pid
									from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where b.trans_pid='.$this->id.') 
									c on e.transuser_invitation = c.promoter_invitation 
									where e.transuser_invitation!="" and c.trans_pid='.$this->id.') as d on d.wx_mobile=f.royalty_mobile where 
									royalty_type like "2%" and d.trans_pid='.$this->id.$where;
    					break;
    				case '2':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,d.trans_proportion as tprotion,
								royalty_type as rtype from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,
								c.promoter_invitation,c.trans_id from h_wxuser e left join (select b.trans_proportion,
    							a.promoter_invitation,b.trans_id from h_promoter_user a left join h_trans_user b 
    							on a.trans_id = b.trans_id where a.trans_id='.$this->id.')as c on e.transuser_invitation = c.promoter_invitation where 
								e.transuser_invitation!="" and c.trans_id='.$this->id.') as d on d.wx_mobile=f.royalty_mobile 
    							where royalty_type like "2%" and d.trans_id='.$this->id.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum*(d.trans_proportion/100)),0)as sum from h_royalty f 
									left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.trans_id from h_wxuser e 
									left join (select b.trans_proportion,a.promoter_invitation,a.trans_id from h_promoter_user a left join 
									h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->id.')as c on 
									e.transuser_invitation = c.promoter_invitation and c.trans_id='.$this->id.' where e.transuser_invitation!="") 
									as d on d.wx_mobile=f.royalty_mobile where royalty_type like "2%" and d.trans_id='.$this->id.$where;
    					break;
    				case '3':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,
    							d.trans_proportion as tprotion,d.promoter_proportion as pprotion,royalty_type as rtype,d.promoter_invitation as pinvition 
    							from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion
    							from h_wxuser e left join (select  b.trans_proportion,a.promoter_invitation,a.promoter_proportion from h_promoter_user as a 
    							left join h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->pid.') 
    							c on e.transuser_invitation = c.promoter_invitation where promoter_invitation="'.$this->invitation.'") as d on 
    							d.wx_mobile=f.royalty_mobile where royalty_type like "2%" and d.promoter_invitation="'.$this->invitation.'"'.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,sum(royalty_comm_sum*(d.trans_proportion/100)*(d.promoter_proportion/100))as sum 
    							from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion 
    							from h_wxuser e left join (select  b.trans_proportion,a.promoter_invitation,a.promoter_proportion from h_promoter_user a 
    							left join h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->pid.') c on e.transuser_invitation = 
    							c.promoter_invitation where promoter_invitation="'.$this->invitation.'") as d on d.wx_mobile=f.royalty_mobile where 
    							royalty_type like "2%" and d.promoter_invitation="'.$this->invitation.'"'.$where;
    					break;
    			}
    			break;
    		case '3':
    			switch ($this->tag){
    				case '1':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,ifnull(royalty_comm_sum,0) as csum 
    							from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,
    							c.promoter_proportion,c.trans_pid from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,
    							a.promoter_proportion,b.trans_pid from h_promoter_user a left join h_trans_user b on a.trans_id = 
    							b.trans_id where b.trans_pid='.$this->id.') c on e.transuser_invitation = c.promoter_invitation where 
    							e.transuser_invitation!="" and c.trans_pid='.$this->id.') as d on d.wx_mobile=f.royalty_mobile where 
    							royalty_type like "3%" and d.trans_pid='.$this->id.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum),0) as sum from h_royalty f left join (
									select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion,c.trans_pid
									from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,a.promoter_proportion ,b.trans_pid
									from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where b.trans_pid='.$this->id.') 
									c on e.transuser_invitation = c.promoter_invitation 
									where e.transuser_invitation!="" and c.trans_pid='.$this->id.' ) as d on d.wx_mobile=f.royalty_mobile where 
									royalty_type like "3%" and d.trans_pid='.$this->id.$where;
    					break;
    				case '2':
    					 $sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,
    					 		d.trans_proportion as tprotion from h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,
    					 		c.promoter_invitation,c.trans_id from h_wxuser e left join (select b.trans_proportion,a.promoter_invitation,b.trans_id 
    					 		from h_promoter_user a left join h_trans_user b on a.trans_id = b.trans_id where b.trans_id='.$this->id.')as c 
								on e.transuser_invitation = c.promoter_invitation where e.transuser_invitation!="" and c.trans_id='.$this->id.') as d 
								on d.wx_mobile=f.royalty_mobile where royalty_type like "3%" and d.trans_id='.$this->id.$where.$limit;
    					 $count_sql = 'select count(royalty_id) as id,ifnull(sum(royalty_comm_sum*(d.trans_proportion/100)),0) as sum from h_royalty f 
									left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation ,c.trans_id from h_wxuser e left join 
									(select b.trans_proportion,a.promoter_invitation ,a.trans_id from h_promoter_user a left join h_trans_user b 
									on a.trans_id = b.trans_id where a.trans_id='.$this->id.')as c on e.transuser_invitation = c.promoter_invitation 
									where e.transuser_invitation!="" and c.trans_id='.$this->id.') as d on d.wx_mobile=f.royalty_mobile where royalty_type like "3%" 
    					 			and d.trans_id='.$this->id.$where;
    					break;
    				case '3':
    					$sql = 'select royalty_id as rid,order_id as oid,royalty_good_name as gname,royalty_order_time as otime,royalty_comm_sum as csum,
    							d.trans_proportion as tprotion,d.promoter_proportion as pprotion,d.promoter_invitation from h_royalty f left join 
    							(select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion from h_wxuser e left 
    							join (select  b.trans_proportion,a.promoter_invitation,a.promoter_proportion from h_promoter_user a left join h_trans_user b on 
    							a.trans_id = b.trans_id where a.trans_id='.$this->pid.') c on e.transuser_invitation =c.promoter_invitation where 
    							promoter_invitation="'.$this->invitation.'") as d on d.wx_mobile=f.royalty_mobile where royalty_type 
    							like "3%" and d.promoter_invitation="'.$this->invitation.'"'.$where.$limit;
    					$count_sql = 'select count(royalty_id) as id,sum(royalty_comm_sum*(d.trans_proportion/100)*(d.promoter_proportion/100)) as sum from 
    							h_royalty f left join (select e.wx_mobile,e.wx_regtime,c.trans_proportion,c.promoter_invitation,c.promoter_proportion from 
    							h_wxuser e left join (select  b.trans_proportion,a.promoter_invitation,a.promoter_proportion from h_promoter_user a left join 
    							h_trans_user b on a.trans_id = b.trans_id where a.trans_id='.$this->pid.') c on e.transuser_invitation = c.promoter_invitation 
    							where promoter_invitation="'.$this->invitation.'") as d on d.wx_mobile=f.royalty_mobile where royalty_type like "3%" 
    							and d.promoter_invitation="'.$this->invitation.'"'.$where;
    					break;
    			}
    			break;
    	}
    	//查询合计单数和成交金额
    	$query=$this->db->query($sql);
    	$count_query = $this->db->query($count_sql);
    	$result = $query->result_array();
    	$count_result = $count_query->result_array();
		//当前页数
		//$return['now'] = $this->page;
		//推广员名下的交易记录信息
		$return['list'] = $result;
		//推广员名下的交易记录合计单数和成交金额 结果集
		$return['count'] = $count_result;
		$return['tag'] = $this->tag;
		$return['num'] = ceil($count_result[0]['id']/$this->num);
		return $return; 
    }
    //佣金结算记录
    function selectCommList(){
    	//开始位置
    	$start =($this->page-1)*$this->num;
    	$count_sql = 'select count(a.settle_id) as id,sum(settle_ready_money) as rmoney from h_settle a where a.settle_people ="'.$this->people.'"';
    	$sql = 'select a.settle_id as sid,a.settle_ready_money as rmoney,a.settle_surplus_money as smoney,a.settle_join_time as jtime from h_settle a 
    			where a.settle_people ="'.$this->people.'" order by settle_id desc';
    	if($start >= 0){
    		$sql .=' limit '. $start.','.$this->num;
    	}
    	$query = $this->db->query($sql);
    	$count_query = $this->db->query($count_sql);
    	$return['count'] = $count_query->result_array();
    	$return['list'] = $query->result_array();
    	$return['num'] = ceil($return['count'][0]['id']/$this->num);
    	return $return;
    }
    //查询当前用户底下的所有代理情况
    function agentList(){
		$where = '';
    	//开始位置
    	$start =($this->page-1)*$this->num;
    	if(!empty($this->starttime)){
    		$where .=' and t.trans_jointime>="'.$this->starttime.'"';
    	}
    	if(!empty($this->endtime)){
    		$where .=' and t.trans_jointime<="'.$this->endtime.'"';
    	}
    	//查询当前用户底下的所有代理信息 1 总代 2二级代理商
    	if ($this->tag =='1' ){
    		//查询总代名下的二级代理的基本信息
    		 $sql = 'select t.trans_id as id,t.trans_phone as name,t.tag as tag,t.trans_jointime as jointime,t.trans_status as status,(select count(*) from h_promoter_user k 
    				left join h_trans_user f on k.trans_id=f.trans_id where f.trans_pid=1 and k.trans_id=t.trans_id) pid,
    				(select IFNULL(sum(d.royalty_comm_sum)*u.trans_proportion/100,0) csum from h_royalty d left join h_wxuser k 
    				on d.royalty_mobile=k.wx_mobile left join h_promoter_user p on p.promoter_invitation=k.transuser_invitation 
    				left join h_trans_user u on p.trans_id=u.trans_id where u.trans_pid='.$this->id.' and u.trans_id=t.trans_id) 
    				as countsum from h_trans_user t where t.trans_pid ='.$this->id.$where;
    		//获取总条数
    		$count_sql = 'select count(t.trans_id) id from h_trans_user t where t.trans_pid ='.$this->id.$where;
    	}else if($this->tag =='2'){
    		if(!empty($this->starttime)){
    			$where .=' and join_time>="'.$this->starttime.'"';
    		}
    		if(!empty($this->endtime)){
    			$where .=' and join_time<="'.$this->endtime.'"';
    		}
    		//二级代理名下的推广员信息
    		$sql = 'select t.promoter_id as id,t.promoter_name as name,t.tag as tag,t.promoter_status as status,t.promoter_jointime as jointime,
    				(select count(*) from h_wxuser k where k.transuser_invitation=t.promoter_invitation) as pid,
    				(select IFNULL(sum(d.royalty_comm_sum),0) from h_royalty d,h_wxuser k where d.royalty_mobile=k.wx_mobile and 
    				k.transuser_invitation=t.promoter_invitation)*e.trans_proportion*t.promoter_proportion/100 as countsum from 
    				h_promoter_user t left join h_trans_user e on t.trans_id=e.trans_id 
    				where t.trans_id ='.$this->id.$where;
    		//获取总条数
    		$count_sql = 'select count(t.promoter_id) id from h_promoter_user t left join h_trans_user e on t.trans_id=e.trans_id where t.trans_id ='.$this->id.$where;
    	}
    	if($start >= 0){
    		$sql .=' limit '. $start.','.$this->num;
    	}
    	$query =$this->db->query($sql);
    	$count_query= $this->db->query($count_sql)->result_array();
    	if($query->num_rows()>0 ){
    		$result=$query->result_array();
    		$result['list']=$result;
    		$result['count']=$count_query[0]['id'];
    	 	$result['num']= ceil($count_query[0]['id']/$this->num);
    		return $result;
    	}else{
    		return false;
    	}
    }
    //获取推广员的二维码
    function getTransInvitation(){
    	$sql = 'select promoter_invitation as invitation,promoter_qrcode as qrcode from h_promoter_user where promoter_name ='.$this->name;
    	$query = $this->db->query($sql);
    	$result = $query->result_array();
    	if($result !=''){
    		return $result;
    	}else{
    		return false;
    	}
    }
    //给自己名下的代理结算佣金
    function checkOut(){
    	$data=array(
    		'settle_ready_money'=>$this->sums,
    		'settle_surplus_money'=>$this->money,
    		'settle_person'=>$this->person,
    		'settle_people'=>$this->people,
    		'settlte_status'=>1,
    		'settle_join_time'=>time()
    	);
    	$sql=$this->db->insert('h_settle',$data);
    	if($sql){
    		return true;
    	}else{
    		return false;
    	}
    }
}