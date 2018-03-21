<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
header('Content-type:text/html;charset=utf-8');

class Quote extends CI_Controller {

    /**
     * 订单报价----显示报价列表
     */
	public function ViewQuote(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        $this->load->helper('array');
        $coulms=array('id');
        $option=elements($coulms, $this->input->get(), '');
        $option['id']=base64_decode($option['id']);
        if(empty($option['id']) || !is_numeric($option['id'])){
             exit();
        }
        $this->load->model('order/quote_model');
        $result = $this->quote_model->checkOrder($option['id'],$user_id);
        if (!$result) {
        	exit();
        }
        $opModel = $this->quote_model->geropModel();
        $result['order']['electronic_oather'] = $this->infoClfic(json_decode($result['order']['electronic_oather']),$opModel);//订单信息重组
        $result['order']['electronic_oather']['other'] = isset($result['order']['electronic_oather']['other'])?explode( ',',$result['order']['electronic_oather']['other']):'';

        $_SESSION['quoteId']=$option['id'];
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $seo=array(
                'title'=>$this->lang->line('seo_name_title'),
                'keyowrd'=>$this->lang->line('seo_name_keyword'),
                'descript'=>$this->lang->line('seo_name_descript'),
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('orderdata',$result);
	    $smarty->assign('header',array('sign'=>'mobile'));
        $smarty->assign('top',$user);
        $smarty->assign('seo',$seo);
        $smarty->assign('foots',$texts);
        $smarty->display('order/offerList.html');
	}
    /**
     * 订单报价----筛选报价
     * @param   int     price        价格
     * @param   int     distance     距离
     * @param   int     evaluation   评价
     * @param   int     transaction  成交单数
     * @param   string  option       服务
     * @param   int     auto         是否认证回收商
     * @return  array                结果集
     */
    function GetScreening(){
        // 校验用户时候在线
        currency::isOnline();
        $this->load->helper('array');
        $coulms=array('price','distance','evaluation','transaction','option','auto');
        $option=elements($coulms, $this->input->post(), '');
        $this->load->model('order/quote_model');
        $data=$this->quote_model->GetScreening($option);
        if(empty($data)){            
            currency::Output($this->config->item('request_fall'));
        }else{            
            currency::Output($this->config->item('request_succ'),'','',$data);
        }
    }
    /**
     * 获取订单详细信息
     */
    function ViewOrderInfo(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        if (!is_numeric($user_id=$_SESSION['user_id'])) {
            exit();
        }
        $orderid=$this->input->get('id',true);
        $this->load->model('order/quote_model');
        $data=$this->quote_model->GetOrderInfo($orderid,$user_id);
        if ($data === false) {
        	exit();
        }
        $opModel = $this->quote_model->geropModel();
        $data['proinfo'] = array();
        $data['proinfo'] = $this->infoClfic(json_decode($data['order']['electronic_oather']),$opModel);
        unset($data['order']['electronic_oather']);
        $data['proinfo']['main']['0'] = implode($data['proinfo']['main']['0'],'/');
        $data['proinfo']['main']['1'] = implode($data['proinfo']['main']['1'],'/');
        $data['proinfo']['other'] = isset($data['proinfo']['other'])?strtr($data['proinfo']['other'],',','/'):'';
        $arr_company=$this->config->item('coop_auth_company');
        array_key_exists($data['offer']['0']['num'],$arr_company) ?
        $data['offer']['0']['name']=''.$arr_company[$data['offer']['0']['num']].'': 
        $data['offer']['0']['name']=mb_substr($orderinfo['0']['cname'],0,1,'utf-8').'师傅';
        
        $hotSeach=$this->config->item('popular_search');
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('data',$data);
        $smarty->assign('se_Left',array('sign_f'=>'order','sign_s'=>'mobile'));
	    $smarty->assign('header',array('sign'=>'mobile'));
        $smarty->assign('top',$user);
        $smarty->assign('hotSeach',$hotSeach);
        $smarty->assign('foots',$texts);
        $smarty->display('order/orderDetails.html');
    }
    /**
     * 选择回收商前 填写详细地址
     * @param    int   fid    报价id
     * @param    int   oid    订单id
     */
    public function address(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        $this->load->helper('array');
        $coulms=array('fid','oid');
        $option=elements($coulms, $this->input->get(), ''); 
        if (!is_numeric($option['fid'])||!is_numeric($option['oid'])||!is_numeric($user_id)) {
            exit();
        }
        $this->load->model('order/quote_model');
        //获取报价
        $orderinfo = $this->quote_model->getOneOrder($option['fid'],$option['oid'],$user_id);
        if ($orderinfo===false) {
            exit();
        }
        $auto=$this->config->item('cooperator_auth_type');
        $orderinfo['0']['cauth']=$auto[$orderinfo['0']['cauth']];
        $arr_company=$this->config->item('coop_auth_company');
        array_key_exists($orderinfo['0']['number'],$arr_company) ?
        $company=''.$arr_company[$orderinfo['0']['number']].'': $company=mb_substr($orderinfo['0']['cname'],0,1,'utf-8').'师傅';
            $orderinfo['0']['ctype']=in_array($orderinfo['0']['number'],$this->config->item('js_cooplist')) ? 1 : 0;
        $orderinfo['0']['cname']=$company;
        $this->load->model('address_model');
        $adreinfo = $this->address_model->getUAdres($user_id);
        
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('order',$orderinfo);
        $smarty->assign('address',$adreinfo);
        $smarty->assign('top',$user);
        $smarty->assign('foots',$texts);
        $smarty->assign('header',array('sign'=>'mobile'));
        $smarty->display('order/submitOrder.html');
    }
    /**
     * 订单报价----选定报价
     * @param     int    oid  订单id
     * @param     int    qid  报价id
     * @param     string city 地址信息
     * @param     string quarters 详细地址
     * @return    成功返回 json  跳转地址 | 失败返回 json 原因
     */
    function ChoiceQuote(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        //校验参数是否为空
        $order=$this->input->post('oid',true);
        $offer=$this->input->post('qid',true);
        if(empty($order) || !is_numeric($order)
            ||empty($offer) || !is_numeric($offer)){
            exit();
        }
        //校验地址信息
        $where['city']=currency::safe_replace($this->input->post('city',true));
        $where['pri']=currency::safe_replace($this->input->post('province',true));
        $where['area']=currency::safe_replace($this->input->post('area',true));
        $detail=currency::safe_replace($this->input->post('adr_detail',true));
        $mobile=$this->input->post('mobile',true);
        if(empty($where['city']) || empty($detail) || empty($mobile) || !is_numeric($mobile)){
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_info_lack'));
        }
        $this->load->model('order/quote_model');
        //补充地址信息
        $up=$this->quote_model->saveAddres($where,$detail,$mobile,$order);
        if(!$up){
            currency::Output($this->config->item('request_fall'),$this->lang->line('adress_save_fall'));
        }
        $res=$this->quote_model->ChoiceQuote($order,$offer);       
        if($res){
            $url='/index.php/order/quote/ViewOrderInfo?id='.$order;
            currency::Output($this->config->item('request_succ'),'',$url);
        }else{
            currency::Output($this->config->item('request_fall'));
        }
    }
    /**
     * 把手机信息进行分类
     * @param      手机的基本信息
     * @param      分类内容
     */
    private function infoClfic($electronic_oather,$opModel){
    	$re_ar = array();
        $re_ar['main']['0'] = array();//基本信息
        $re_ar['main']['1'] = array();//其它问题
        foreach ($electronic_oather as $k => $v) {
        	foreach ($opModel as $key => $value) {
        		if ($k==='other') {
        			$re_ar['other'] = $v;
        			break;
        		}
        		if ($k == $value['model_alias']&&$value['model_type']=='0') {
        		    $re_ar['main']['0'][] = $value['model_name'].' '.$v;
        			break;
        	    }else if($k == $value['model_alias']){
    				$re_ar['main']['1'][] = $value['model_name'].' '.$v;
        			break;
        	    }
        	}
        }
        return $re_ar;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */