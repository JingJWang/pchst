<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class currency{    
    /**
     * 替换函数
     * @param   string    string   要过滤的字符串
     * @return  返回string  过滤完的字符串
     */
    public static function  safe_replace($string){
        $serach=array('[',']','/',',','&','%20','%27','%2527','*','"',';','<','>','{','}',' ');
        $replace=array('','','', '', '','','','','','','','','','','','');
        return str_replace($serach, $replace, $string);
    }
    /**
     * 过滤SQL注入
     * @param   string  sql_str   要过滤的字符串
     * @return  返回过滤完的sql
     */
    function inject_check($sql_str) {
        return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile',$sql_str);    // 进行过滤
    }
    /**
     * 转义用户输入的字符串
     * @param   string   string  需要的转义的字符串
     * @return  返回转义完成的字符串
     */
    public static function filter($string) {
        if (!get_magic_quotes_gpc()) {                // 判断magic_quotes_gpc是否为打开
            $string = addslashes($string);            // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
        }
        $string = htmlspecialchars($string);          // html标记转换
        $string = str_replace('%', '\%', $string);    // 把 '%'过滤掉
        $string = str_replace(';', '\;', $string);    // 把 '_'过滤掉
        $string = str_replace("'", '\_', $string);
        $string = nl2br($string);                     // 回车转换
        return $string;
    }
    /**
     * Ajax 请求返回数据函数
     * @param   int     s    返回的状态码
     * @param   int     m    返回提示信息
     * @param   string  u    返回的跳转地址
     * @param   array   d    返回的数据
     * @return  输出json 字符串
     */
    public static function Output($s,$m='',$u='',$d=''){
        $response=array('status'=>$s,'msg'=>$m,'url'=>$u,'data'=>$d);
        echo json_encode($response);exit;
    }
    /**
     * log 日志函数
     * @param    string   name      日志名称
     * @param    string   content   内容   格式为  http request Ip 请求IP  log content  日志内容
     */
    public static function SystemLog($name,$content){
        $log_name='logs/'.date('Y-m-d').$name;
        $content='请求时间'.date('Y-m-d H:i:s').'文件'.$content;
        file_put_contents($log_name,$content,FILE_APPEND);
    }
    /**
     * 判断请求方式是否是POST
     */
    public static  function IsPOST(){
        if ($this->input->server('REQUEST_METHOD') != "POST"){
            Universal::Output($this->config->item('app_req_method_err'),
            $this->lang->line('app_req_method_err'));
        }
    }
    /**
     * 校验当前用户是否已经登录  且跳转到登录页面
     * @param returnUrl 注册成功后 返回地址
     */
    public static function isOnline($returnUrl = ''){
        if(!isset($_SESSION['user_online']) || $_SESSION['user_online'] != 'ok'){
            header("Location:/index.php/user/login?returnUrl=".urlencode($returnUrl));
            exit();
        }
    }   
    /**
     * 校验当前用户是否已经登录 
     * @return  bool  登录返回true|没登录返回false 
     */
    public static function checkOnline(){
        if(!isset($_SESSION['user_online']) || $_SESSION['user_online'] != 'ok'){
           return false;
        }else{
           return true;
        }
    }
    /**
     * 校验当前用户是否已经登录 长沙系统
     * @return  bool  登录返回true|没登录返回false
     */
    public static function checkOnlineCS(){
    	if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    		header("Location:/index.php/trans/login"); exit();
    	}else{
    		return true;
    	}
    }
    /**
     * 读取session存放的用户信息
     */
    public static function getUser(){   
    	$id =isset($_SESSION['id']) ? $_SESSION['id'] :  '' ;
    	$tag=isset($_SESSION['tag']) ? $_SESSION['tag'] :  '' ;
        $photo=empty($_SESSION['user_img']) ? '/static/home/images/avatar.png' : $_SESSION['user_img'];
        $name=isset($_SESSION['user_name']) ? $_SESSION['user_name'] :  '' ;
        $user=array('photo'=>$photo,'name'=>$name,'id'=>$id,'tag'=>$tag);
        return $user;
    }
    /**
     * 中文二元分词 编码utf-8
     */
    public static function SplitWord($str){
        $cstr = array();
        $search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`",
                "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">",
                "\r", "\r\n", "{1}quot;", "&", "%", "#", "@", "+",
                "=", "{", "}", "[", "]", "：", "）", "（", "．", "。",
                "，", "！", "；", "“", "”", "‘", "’", "［", "］", "、",
                "—", "　", "《", "》", "－", "…", "【", "】","$");
        $str = str_replace($search, " ", $str);
        preg_match_all("/[a-zA-Z]+/", $str, $estr);
        preg_match_all("/[0-9]+/", $str, $nstr);
        $str = preg_replace("/[0-9a-zA-Z]+/", " ", $str);
        $str = preg_replace("/\s{2,}/", " ", $str);
        $str = explode(" ", trim($str));
        foreach ($str as $s) {
            $l = strlen($s);
            $bf = null;
            for ($i= 0; $i< $l; $i=$i+3) {
                $ns1 = $s{$i}.$s{$i+1}.$s{$i+2};
                if (isset($s{$i+3})) {
                    $ns2 = $s{$i+3}.$s{$i+4}.$s{$i+5};
                    if (preg_match("/[\x80-\xff]{3}/",$ns2)) $cstr[] = $ns1.$ns2;
                } else if ($i == 0) {
                    $cstr[] = $ns1;
                }
            }
        }
        $estr = isset($estr[0])?$estr[0]:array();
        $nstr = isset($nstr[0])?$nstr[0]:array();
        return array_merge($nstr,$estr,$cstr);
    }
    /**
     * 创建订单编号
     * @return string
     */
    public static  function create_ordrenumber(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).rand(1000,9999);
    }
    /**
     * curl post 请求
     */
    public static function curlPost($uri,$data){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $response = curl_exec ( $ch );
        curl_close ( $ch );
        return $response;
    }
    /**
     * curl　get 方法
     */
    static  function curlGet($uri){
        $ch = curl_init() ;
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $response = curl_exec($ch) ;
        curl_close ( $ch );
        return $response;
    }
}