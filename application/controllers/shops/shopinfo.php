<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
/**
 * 
 * @author xiaotao
 * 个人中心模块
 */
class  Shopinfo extends CI_Controller{
    /**
     * 商城首页
     */
    function index(){
        $user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $this->load->model('shops_model');
        $goods = $this->shops_model->getIndexInfo();
        $types = $this->shops_model->getTypes();
        //为分类找到子集
        $f_arr = array();
        foreach ($types as $k => $v) {
            if ($v['fid']==0) {
                $f_arr[] = $v['id'];
                if ($v['id']!=4) {
                    unset($types[$k]);
                }
            }
        }
        $arr = array(
            's_arr'=>array(),
            'types'=>$types,
        );
        foreach ($types as $k => $v) {
            if (in_array($v['fid'],$f_arr)||$v['id']==4) {//第二级的找子类
                $arr['s_arr'] = array();
                $arr = $this->getson($v['id'],$arr);
                if (!empty($arr['s_arr'])) {
                    $types[$k]['son'] = $arr['s_arr'];
                    unset($arr['types'][$k]);//删除已经获得子集的元素
                }
                foreach ($goods as $key => $value) {
                    if ($v['id'] == $value['tyid']|| (isset($v['son'])&&in_array($value['tyid'],$v['son']['sonids']))) {
                        $value['property'] = json_decode($value['property'],true);
                        $types[$k]['goods'][] = $value;
                        unset($goods[$key]);
                    }
                }
            }else{
                unset($types[$k]);
            }
        }
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();

        $seo=array(
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('seo',$seo);
        $smarty->assign('top',$user);
        $smarty->assign('types',$types);
        $smarty->assign('foots',$texts);
        $smarty->display('shop/shop.html');

    }
    /**
     * 获取某个类型的商品
     */
    function getypegood(){
        $user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $id_page = $this->uri->segment(4);
        $arr = explode('_', $id_page);
        $id = $arr['0'];
        if (!isset($arr['1'])) {
            $page = 1;
        }else{
            $page = $arr['1'];
        }
        $orderBy = '';
        if (!isset($arr['2'])) {
            $sort = 1;
        }else{
            switch ($arr['2']) {
                case '1':
                    break;
                case '2'://时间排序
                    $orderBy = 'order by goods_jointime desc';
                    break;
                case '3'://价格降序排序
                    $orderBy = 'order by goods_ppri desc';
                    break;
                case '4'://价格升序排序
                    $orderBy = 'order by goods_ppri asc';
                    break;
                default:
                    return ;
                    break;
            }
            $sort = $arr['2'];
        }
        if (!is_numeric($page)||!is_numeric($id)||!is_numeric($sort)) {
            return ;
        }
        $attri = $this->uri->segment(5);
        $attri_str = $where ='';
        $haveAttri = array();
        $haveAttriArr = array();
        if ($attri!==false) {
            $attri_arr = explode('_', $attri);
            foreach ($attri_arr as $k => $v) {
                $arr = explode('-', $v);
                if (!is_numeric($arr['0'])||!isset($arr['1'])||!is_numeric($arr['1'])) {
                    return ;
                }
                $haveAttri[$arr['0']] = $arr['1'];
                $haveAttriArr[$arr['0']] = $v;
                $attri_str .= ' find_in_set("'.$v.'",goods_attributes) and';
            }
            $attri_str = rtrim($attri_str,' and');
            $where .= 'and '.$attri_str.'';
        }
        $this->load->model('shops_model');
        $typeInfo = $this->shops_model->getOneType($id);
        if ($typeInfo==false) {
            exit;
        }
        $types = $this->sortypes($id,$typeInfo['0']['type_fid']);
        $sonids = empty($types['thisTypeSon'])?'':','.implode(',', $types['thisTypeSon']);
        $where = 'goods_typeid in ('.$id.$sonids.') '.$where;
        $typeInfo['0']['type_attributes'] = json_decode($typeInfo['0']['type_attributes'],true);
        $goods = $this->shops_model->getTypeGood('goods_status=1 and '.$where.' '.$orderBy);
        if ($goods==false) {
            $goods_num = 0;
        }else{
            $goods_num = count($goods);
        }
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $seo=array(
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        if ($goods_num>24) {
            $goods = array_slice($goods,24*($page-1),24);
        }
        
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('seo',$seo);
        $smarty->assign('top',$user);
        $smarty->assign('pageinfo',array('id'=>$id,'page'=>$page,'sort'=>$sort));
        $smarty->assign('attri',$attri);
        $smarty->assign('haveAttriArr',$haveAttriArr);
        $smarty->assign('typeInfo',$typeInfo);
        $smarty->assign('haveAttri',$haveAttri);
        $smarty->assign('goods',$goods);
        $smarty->assign('goods_num',$goods_num);
        $smarty->assign('types',$types);
        $smarty->assign('foots',$texts);
        $smarty->display('shop/phones.html');
    }
    /**
     * 分类排序
     * @param   int     id      要选择的id
     * @return  type    排序号的所有分类 | thisTypeSon  选择此id下的所有子分类id | 父级元素的信息
     */
    function sortypes($id='',$fid=''){
        $types = $this->shops_model->getTypes();
        $f_arr = array();
        foreach ($types as $k => $v) {
            if ($v['fid']==0) {
                $f_arr[] = $v['id'];
                if ($v['id']!=4) {
                    unset($types[$k]);
                }
            }
        }
        $arr = array(
            's_arr'=>array(),
            'types'=>$types,
        );
        $thisTypeSon  = array();
        $thisTypeFa = '';
        foreach ($types as $k => $v) {
            if (in_array($v['fid'],$f_arr)) {//第二级的找子类
                $arr['s_arr'] = array();
                $arr = $this->getson($v['id'],$arr);
                if (!empty($arr['s_arr'])) {
                    $types[$k]['son'] = $arr['s_arr'];
                    unset($arr['types'][$k]);//删除已经获得子集的元素
                }
                if ($id!=''&&$v['id']==$id&&isset($types[$k]['son'])) {
                    $thisTypeSon = $types[$k]['son']['sonids'];
                }
                if ($fid!=''&&$v['id']==$fid) {
                    $thisTypeFa = $v;
                }
            }else{
                if ($v['id']!=4) {
                    unset($types[$k]);
                }
            }
        }
        return array('type'=>$types,'thisTypeSon'=>$thisTypeSon,'thisTypeFa'=>$thisTypeFa);
    }
    /**
     * 获取某个商品的信息
     * @param       int     gid     商品的id
     */
    function getgoodinfo(){
        $user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $gid = $this->uri->segment(4);
        if ($gid==false||!is_numeric($gid)) {
            return ;
        }
        $this->load->model('shops_model');
        $types = $this->sortypes();
        $goodinfo = $this->shops_model->getOneInfo($gid);
        if ($goodinfo==false) {
            return ;
        }
        $des = '';
        if ($goodinfo['0']['attri']!=''&&$goodinfo['0']['battri']!='') {
            $goodinfo['0']['battri'] = json_decode($goodinfo['0']['battri'],true);
            $arr = explode(',',$goodinfo['0']['attri']);
            foreach ($arr as $k => $v) {
                $desarr = explode('-', $v);
                $des[] = $goodinfo['0']['battri'][$desarr['0']]['1'][$desarr['1']];
            }
        }
        $goodinfo['0']['imgs']=array_filter(explode('|',$goodinfo['0']['imgs']));
        $this->config->load('shop',true);//配置项加载
        $shopConfig = $this->config->item('shop');
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $seo=array(
                'host_name' => $_SERVER['HTTP_HOST'],
        );
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('seo',$seo);
        $smarty->assign('top',$user);
        $smarty->assign('des',$des);
        $smarty->assign('goodinfo',$goodinfo);
        $smarty->assign('types',$types);
        $smarty->assign('foots',$texts);
        $smarty->assign('srecom',$shopConfig['shop_recommend']);
        $smarty->display('shop/productDetail.html');
    }
    /**
     * 确定购买信息
     */
    function buginfo(){
        // 校验用户时候在线
        currency::isOnline($_SERVER['REQUEST_URI']);
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        $gid = $this->uri->segment(4);
        if ($gid==false||!is_numeric($gid)) {
            return ;
        }
        $this->load->model('shops_model');
        $types = $this->sortypes();
        $goodinfo = $this->shops_model->goodinfo($gid);

        $goodinfo['0']['otherprice'] = json_decode($goodinfo['0']['otherprice'],true);
        $goodinfo['0']['otherprice']['0']['p'] = $goodinfo['0']['prri'];
        $goodinfo['0']['otherprice']['0']['in'] = $goodinfo['0']['integral'];

        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        if ($goodinfo['0']['fid']==2) {
            $this->load->model('address_model');
            $addres = $this->address_model->getUAdres($user_id);
            $smarty->assign('address',$addres); 
        }
        $smarty->assign('top',$user);
        $smarty->assign('foots',$texts);
        $smarty->assign('types',$types);
        $smarty->assign('mobile',$_SESSION['user_mobile']);
        $smarty->assign('goodinfo',$goodinfo);
        $smarty->display('shop/confirmation.html');
    }
    /**
     * 用户订单
     */
    function shoplist(){
        // 校验用户时候在线
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        if (!is_numeric($user_id)) {
            return ;
        }
        $this->load->model('shops_model');
        $result = $this->shops_model->getUserList($user_id);
        currency::Output($this->config->item('request_succ'),'','',$result);
    }
    /**
     * 获取某个类型的所有子类型
     * @param      int      typeid      类型id
     * @param      array    types       需要分类的全部类型
     * @param      array    arr         用于记录已经未分类的类型和此类型的所有子类型id。
     * @return      array    s_arr       此类型所有的子集id|| types      筛选后，删除此类型的所有子集后的类型
     */
    function getson($typeid,$arr){
        foreach ($arr['types'] as $k => $v) {
            if ($v['fid']==$typeid) {
                $arr['s_arr']['sonids'][] = $id = $v['id'];
                $arr['s_arr']['sontype'][] = $v;
                unset($arr['types'][$k]);
                $arr = $this->getson($id,$arr);
            }
        }
        return array('s_arr'=>$arr['s_arr'],'types'=>$arr['types']);
    }
    /**
     * 某个订单详情
     * @param       int      order_id       订单的id
     */
    function orderdetail(){
        $order_id=$this->uri->segment(4);
        currency::isOnline();
        $user=currency::getUser();//用户信息
        $user_id = $_SESSION['user_id'];
        if (!is_numeric($order_id)||!is_numeric($user_id)) {
            return ;
        }
        $this->load->model('shops_model');
        $orderinfo = $this->shops_model->getOrderDetail($order_id,$user_id);
        if ($orderinfo==false) {
            $orderinfo = '';
        }else{
            $orderinfo['0']['adress'] = explode(',', $orderinfo['0']['adress']);
            $orderinfo['0']['code'] = explode(',', $orderinfo['0']['code']);
        }
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('se_Left',array('sign_f'=>'order','sign_s'=>'shop'));
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $types = $this->sortypes();
        $smarty->assign('top',$user);
        $smarty->assign('types',$types);
        $smarty->assign('orderinfo',$orderinfo);
        $smarty->assign('foots',$texts);
        $smarty->display('shop/orderDetail.html');
    }
    /**
     * 搜索商品
     */
    function searchshop(){
        $user = '';
        if (isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok') {
            $user=currency::getUser();//用户信息
        }
        $sort=$this->uri->segment(5);
        switch ($sort) {
            case '1':
                $orderBy = '';
                break;
            case '2'://时间排序
                $orderBy = 'order by goods_jointime desc';
                break;
            case '3'://价格降序排序
                $orderBy = 'order by goods_ppri desc';
                break;
            case '4'://价格升序排序
                $orderBy = 'order by goods_ppri asc';
                break;
            default:
                return ;
                break;
        }
        $page=$this->uri->segment(6);
        if ($page==false) {
            $page=1;
        }
        if (!is_numeric($page)) {
            return ;
        }
        $text=$this->uri->segment(4);
        $text = urldecode($text);
        $text_ne = currency::SplitWord($text);
        $this->load->model('shops_model');
        $result = $this->shops_model->searchShops($text_ne,$orderBy);
        $num = count($result);
        $result = array_slice($result,24*($page-1),24);
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $types = $this->sortypes();
        $smarty->assign('top',$user);
        $smarty->assign('types',$types);
        $smarty->assign('foots',$texts);
        $smarty->assign('goods',$result);
        $smarty->assign('num',$num);
        $smarty->assign('sort',$sort);
        $smarty->assign('page',$page);
        $smarty->assign('searchtext',$text);
        $smarty->display('shop/search.html');
    }
}