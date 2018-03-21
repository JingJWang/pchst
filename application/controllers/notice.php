<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();

class Notice extends CI_Controller {
    
    /**
     * 获取公司通知
     * @param      int       nid      文章的id
     */
	public function getnotice(){
		$url = $_SERVER['REQUEST_URI'];
		$this->load->library('smarty/tpl');
		$smarty = $this->tpl->getSmarty();
		$smarty = $this->getCache($smarty,$url,'tpl/notice.html');
		$nid = $this->uri->segment(3);
		if (!is_numeric($nid)) {
			exit;
		}
		$this->load->model('notice_model');
		$texts = $this->notice_model->getAllNotice();
		if ($texts===false) {
			exit();
		}
		$aimtext = $this->notice_model->getTypeNotice($nid);
		if ($aimtext===false) {
			exit();
		}
        $seo=array(
               'host_name' => $_SERVER['HTTP_HOST'],
        );
		$smarty->assign('texts',$texts);
        $smarty->assign('foots',$texts);
        $smarty->assign('seo',$seo);
		$smarty->assign('thetext',$aimtext);
        $smarty->assign('header',array('sign'=>'home'));
		$smarty->display('tpl/notice.html',md5($url));
	}
	/**
	 * 获取公司资讯
	 */
	public function Information(){
		$url = $_SERVER['REQUEST_URI'];
		$this->load->library('smarty/tpl');
		$smarty = $this->tpl->getSmarty();
		$smarty = $this->getCache($smarty,$url,'tpl/information.html');
		$rec_read = $this->config->item('rec_read');
        //无缓存开始读取库内容
		$type = $this->uri->segment(3);
		if (!is_numeric($type)) {
			exit();
		}
    	$user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
		$this->load->model('notice_model');
		$texts = $this->notice_model->getAllNotice();
		$types = $this->notice_model->getArticleType();
		$textlist = $this->notice_model->oneTypeText($type);
		
        $smarty->assign('rec_read',$rec_read);
        $smarty->assign('seo',$seo);
        $smarty->assign('foots',$texts);
        $smarty->assign('types',$types);
        $smarty->assign('texts',$textlist);
        $smarty->assign('header',array('sign'=>'home'));
        $smarty->assign('type',$type);
		$smarty->display('tpl/information.html',md5($url));
	}
	/**
	 * 读取文章信息
	 */
	public function artical(){
		$url = $_SERVER['REQUEST_URI'];
		$this->load->library('smarty/tpl');
		$smarty = $this->tpl->getSmarty();
		$smarty = $this->getCache($smarty,$url,'tpl/artical.html');
		$rec_read = $this->config->item('rec_read');
        //无缓存开始读取库内容
		$tid = $this->uri->segment(3);
		if (!is_numeric($tid)) {
			exit();
		}
		$this->load->model('notice_model');
		$texts = $this->notice_model->getAllNotice();
		$types = $this->notice_model->getArticleType();
		$text = $this->notice_model->getAText($tid);
		if ($text==false||$text['0']['type']==0) {
			exit();
		}
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $text['0']['text'] = json_decode($text['0']['text']);
        $smarty->assign('rec_read',$rec_read);
        $smarty->assign('seo',$seo);
        $smarty->assign('foots',$texts);
        $smarty->assign('types',$types);
        $smarty->assign('text',$text);
        $smarty->assign('header',array('sign'=>'home'));
		$smarty->display('tpl/artical.html',md5($url));
	}
	/**
	 * 判断是否有缓存
	 * @param		object		smarty		
	 * @param		string		页面的地址
	 * @param		string		模板的链接
	 */
	private function getCache($smarty,$url,$cUrl){
        $smarty->caching = false;//开启缓存
        $smarty->cache_lifetime = 7200;
    	$user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $smarty->assign('top',$user);//不用缓存的内容
        if ($smarty->isCached($cUrl,md5($url))) {   //直接读取缓存
			$smarty->display($cUrl,md5($url));
            exit();
        }
        return $smarty;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */