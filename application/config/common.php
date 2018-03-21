<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//错误提示码
$config['request_fall']                       =  3000;       //请求出现异常提示返回
$config['request_succ']                       =  1000;       //请求正常返回
//redis配置
$config['redis_config_aliyun']                =  array(      //redis 配置测试环境
            'environment'=>'development',
            'host'=>'123.57.59.0',
            'port'=>6379,
            'user'=>'root',
            'pwd'=>'404error'
);
/*********阿里大鱼 SDK配置信息***********/
$config['alidayu_appkey']                   = '23309599';                              //阿里大鱼SDK  key
$config['alidayu_secretKey']                = '8064bd60f7da3957208191191f6d759c';      //阿里大鱼SDK  secretKey
$config['alidayu_signname']                 = '回收通';                                  //短信签名
$config['alidayu_extend']                   = '1001';                                  //知通科技 回收通项目编号
$config['alidayu_sendsucc']                 =  0;                                      //阿里大鱼短信发送成功标示
$config['alidayu_shownum']                  = '051482043260';                          //语音验证码呼入号码
/*************阿里大鱼 模板*************/
$config['alidayu_templte_voicecode']        = 'TTS_5002361';                           //语音验证码模板id
$config['alidayu_templte_extractcash']      = 'SMS_5077262';                           //提现短信验证码模板id
$config['alidayu_templte_register']         = 'SMS_13207012';                          //PC版登陆验证码模板
/*************微信登录 使用的配置项******/
$config['wxlogin_appid']                    = 'wx29a596b5eac42c22';                    //微信登录appid
$config['wxlogin_appsecrett']               = '2129003c8d29a592d8f39e4cf0ebf8fe';      //微信登录appsecrett
/***************路径/跳转*****************/
$config['center_default_photo']             = '/static/home/images/head2.jpg';          //个人中心默认头像
$config['url_login']                        = '/index.php/user/login';
/*****************聚合数据key********************/
$config['jhdata_key']                       = 'a48dd122993acda9a38bb04a423cfa6f';       //聚合数据key
/**************回收商模块****************/
$config['coop_auth_company']                = array(                                    //回收商认证单位
            '151215593588660'=>'苏博电子（非寄售）',
            '160629486457725'=>'展讯通信',
            '160129436549154'=>'迪华通讯',
            '160129441816953'=>'程维科技',
            '160129449155290'=>'苏博电子'
);

$config['js_cooplist']                      = array('160129449155290');                 //标示寄售商
/***************回收商认证*****************/
$config['cooperator_auth_type']             = array(
            '0' => '未认证',
            '1'=>'个人认证',
            '2'=>'企业认证',
            '3'=>'保证金认证',
            '4'=>'个人+保证金认证',
            '5' =>'企业+保证金认证');

/************系统常用项配置***********/
$config['popular_search']                   = array(                    //比较欢迎的热搜词
            '0'=>array('name'=>'iPhone 6','id'=>'730'),  
            '1'=>array('name'=>'iPhone 5s','id'=>'727'),
            '2'=>array('name'=>'小米 3','id'=>'737'),
            '3'=>array('name'=>'OPPO R7','id'=>'1681'),);

$config['popular_mobile']                   = array(                   //热门手机
            '0'=>array('name'=>'iPhone 6','id'=>'730'),  
            '1'=>array('name'=>'华为 荣耀3C','id'=>'756'),
            '2'=>array('name'=>'小米 3','id'=>'737'),
            '3'=>array('name'=>'OPPO R7','id'=>'1681'),
            '4'=>array('name'=>'红米 Note','id'=>'738'),
            '5'=>array('name'=>'诺基亚 638','id'=>'1231'),
            '6'=>array('name'=>'vivo X5Pro','id'=>'1811'),
            '7'=>array('name'=>'摩托罗拉 ME525+','id'=>'911'),
            '8'=>array('name'=>'索尼 XperiaArcSLT18i','id'=>'985'),
            '9'=>array('name'=>'锤子 坚果（YQ601）','id'=>'2132'),
);

$config['user_comment']                     = array(                    //用户的评论
            '0'=>array('address'=>'北京','face'=>'/static/home/images/head.png','comment'=>'操作便捷，回收价高，安全有保障'),
            '1'=>array('address'=>'上海','face'=>'/static/home/images/head.png','comment'=>'成功卖出了手机'),
            '2'=>array('address'=>'天津','face'=>'/static/home/images/head.png','comment'=>'速度很快，有保障'),
            '3'=>array('address'=>'新疆','face'=>'/static/home/images/head.png','comment'=>'goods'),
);

$config['rec_read']                         = array(                    //推荐阅读
            '0'=>array('title'=>'免费抢第一批官方价购买iPhone7名额，肾7在手天下我有【回收通】','url'=>'/index.php/notice/artical/11'),
            '1'=>array('title'=>'常见问题','url'=>'/index.php/notice/getnotice/3'),
);

/*******贵重金属纯度*******/
$config['gold_purity']                 =  array(
            '1'=>'24K(含金量99.99%)',
            '2'=>'24K(含金量99%)',
            '3'=>'22K(含金量91%)',
            '4'=>'18K(含金量75%)'
);
$config['platinum_purity']             =  array(
            '1'=>'纯银(含银量99.9%)',
            '2'=>'标准银(含银量92.5%)'
);
$config['silver_purity']               =  array(
       '1'=>'铂Pt900(代表含铂量900‰)',
       '2'=>'铂Pt950(代表含铂量950‰)',
       '3'=>'足铂Pt990(代表含铂量990‰)',
       '4'=>'千足铂Pt999(代表含铂量999‰)'
);
/***********贵重金属类型************/
$config['metal_type']                  =  array(
        '1'=>array('name'=>'黄金','img'=>'gold.png'),
        '2'=>array('name'=>'铂金','img'=>'gold1.png'),
        '3'=>array('name'=>'白银','img'=>'gold2.png')
);
$config['metal_classify']              =  array(
         '1'=>'投资金条',
         '2'=>'投资金币',
         '3'=>'投资金锭',
         '4'=>'黄金饰品',
         '5'=>'黄金摆件'    
);      
