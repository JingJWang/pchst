<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();

class Brand extends CI_Controller {
	/**
	 * 获取品牌类型列表
	 * @param         int        type       品牌类型id
	 * @return        json       品牌列表和第一个品牌的商品
	 */
	public function getorder(){
		$type = $this->input->post('type',true);
		if (!is_numeric($type)) {
			exit;
		}
		$this->load->model('home/brand_model');
		$brand = $this->brand_model->getBrand($type);
		if ($brand == false) {
            currency::Output($this->config->item('request_fall'),'','','');
		}
		if ($type==5) {//得到默认的品牌id
			$mid = 1;
			$where = 'mobile';
		}elseif($type==7){
			$mid = 5;
			$where = 'flat';
		}
		$shops = $this->brand_model->getShops($brand[$mid ]['id'],'0');
        currency::Output($this->config->item('request_succ'),'','',
        	             array('brand'=>array_slice($brand,0,13),'shops'=>array_slice($shops,0,6),'where'=>$where));
	}
	/**
	 * 获取品牌下的商品(主页下)
	 * @param         int        bid        品牌id
	 */
	public function getshops(){
		$bid = $this->input->post('bid',true);
		if (!is_numeric($bid)) {
            currency::Output($this->config->item('request_fall'),'','','');
		}
		$this->load->model('home/brand_model');
		$shops = $this->brand_model->getShops($bid,'0');
        currency::Output($this->config->item('request_succ'),'','',array_slice($shops,0,6));
	}
	/**
	 * 获取评论信息
	 */
	public function comments(){
        $comments=$this->config->item('user_comment');
        $data['com'] = array('comments'=>$comments);
        echo json_encode($data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */