<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();

class Recover extends CI_Controller {
    /**
     * 验证get信息
     * @param        string       get       获取get的第3个参数
     * @param        int          type      品牌类型
     * @param        int          mid       默认获取的品牌
     * @return       array        返回获取的信息
     */
    private function common($type,$mid){
		$bid = $this->uri->segment(3);
		$bandid = null;
		$star = 0;
		if ($bid!==false) {//判断参数是否正确
    		$bid = explode('-', $bid);
    		switch ($bid['0']['0']) 
    		{
    			case 'p'://只显示页数,获得此类型全部的品牌    空 /p1
    			    if (!is_numeric($star=ltrim($bid['0'],'p'))) {
    			        return false;
    			    }
    				break;
    			case 'b'://有品牌了   /b1  /b1-p2
			        if(!is_numeric($bandid=ltrim($bid['0'],'b'))){
			        	return false;
			        }
			        $star = 0;
			        if (isset($bid['1'])&&($bid['1']['0']!=='p'||!is_numeric($star=ltrim($bid['1'],'p')))) {
			        	return false;
			        }
    				break;
    			default:
        			return false;
    				break;
    		}
		}
    	//获取品牌列表
		$this->load->model('home/brand_model');
		$brand = $this->brand_model->getBrand($type);
		if ($brand === false) {
			return array('b'=>$bandid,'p'=>$star);
		}
		$brand_ar = array();//得到品牌所有的id
		foreach ($brand as $k => $v) {
			$brand_ar[]=$v['id'];
		}
		if ($bandid==null) {
			$bandid = $brand[$mid]['id'];//默认苹果
		}elseif (!in_array($bandid, $brand_ar)) {
			return false;
		}
		$shops = $this->brand_model->getShops($bandid,($star*24));
		if ($shops===false) {
			return false;
		}
		$shopnum = $this->brand_model->getShNum($bandid);
		return array('brand'=>$brand,'shops'=>$shops,
			         'snum'=>$shopnum,'b'=>$bandid,'p'=>$star);
    }
	/**
	 * 获取手机的信息
	 */
	function mobile(){
		$result = $this->common('5','1');
		if ($result===false) {
			exit;
		}
		$result['other']['type'] = 'mobile';
	    $this->endCommon($result);
	}
	/**
	 * 平板信息
	 */
	function flat(){
		$result = $this->common('7','5');
		if ($result===false) {
			exit;
		}
		$result['other']['type'] = 'flat';
	    $this->endCommon($result);
	}
	/**
	 * 搜索界面
	 * @param       string      text       要搜索的文字
	 */
	function search(){
		$text = $this->uri->segment(3);
		$types = $this->uri->segment(4);
		$page = $this->uri->segment(5);
		if ($page===false) {
			$page = 0;
		}elseif(!is_numeric($page)){
			exit();
		}
		switch ($types) {
			case 'mobile':
                $type = '5';
				break;
			case 'flat':
                $type = '7';
				break;
			default:
			    exit();
				break;
		}
		$text = urldecode($text);
		$text_ne = currency::SplitWord($text);
		$this->load->model('home/brand_model');
		$brand = $this->brand_model->getBrand($type);
		if ($brand === false) {
			exit;
		}
		$brand_str = '';//得到品牌所有的id
		foreach ($brand as $k => $v) {
			$brand_str.=$v['id'].',';
		}
		$shops = $this->brand_model->seachShop(rtrim($brand_str,','),$text_ne);
		$anum = ($shops===false)?0:count($shops);
		$starn = $page*24;
		if ($anum>24) {
			if ($starn<$anum) {
				$shops = array_slice($shops,$starn,24);
			}else{
				exit();
			}
		}
		$arr['0']['allnum'] = $anum;
		$result = array('brand'=>$brand,'shops'=>$shops,
			         'snum'=>$arr,'b'=>'-1','p'=>$page);
		$result['other']['type'] = $types;
		$result['other']['search'] = $text;
		$this->endCommon($result);
	}
	/**
	 * 传入参数到模板引擎中
	 */
    function endCommon($result){
        $user=currency::getUser();
        $hotSeach=$this->config->item('popular_search');
		$this->load->model('notice_model');
		$texts = $this->notice_model->getAllNotice();
	    $this->load->library('smarty/tpl');
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $result['other']['hotmobile'] = $this->config->item('popular_mobile');
	    $smarty=$this->tpl->getSmarty();
		$result['other']['b'] = $result['b'];
		$result['other']['p'] = $result['p'];
	    $smarty->assign('brand',$result['brand']);
	    $smarty->assign('shops',$result['shops']);
	    $smarty->assign('snum',$result['snum']['0']);
	    $smarty->assign('other',$result['other']);
        $smarty->assign('seo',$seo);
        $smarty->assign('top',$user);
        $smarty->assign('hotSeach',$hotSeach);
	    $smarty->assign('header',array('sign'=>'mobile'));
        $smarty->assign('foots',$texts);
	    $smarty->display('recovery.html');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */