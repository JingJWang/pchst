<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
/************商城推荐商品***********/
$config['shop_recommend']                   = array(                   //热门手机
            '0'=>array(
                'name'=>'iphone6plus美版金色64g 手机',
                'id'=>'341',
                'img'=>'http://wx.recytl.com/static/shop/images/110103.jpg',
                'price'=>'￥2050'
            ),  
            '1'=>array(
                'name'=>'三星s4 手机白色',
                'id'=>'350',
                'img'=>'http://wx.recytl.com/static/shop/images/110403.jpg',
                'price'=>'￥240'
            ),
            '2'=>array(
                'name'=>'华为P7手机',
                'id'=>'361',
                'img'=>'http://wx.recytl.com/static/shop/images/111403.jpg',
                'price'=>'￥420'
            ),
            '3'=>array(
                'name'=>'乐视1S手机',
                'id'=>'362',
                'img'=>'http://wx.recytl.com/static/shop/images/111404.jpg',
                'price'=>'￥480'
            ),
            '4'=>array(
                'name'=>'三星S4手机',
                'id'=>'365',
                'img'=>'http://wx.recytl.com/static/shop/images/111503.jpg',
                'price'=>'￥260'
            ),
);
/**********运营商手机头几位区别****************/
$config['mobile_operators'] = array(
                            'corporation'=>array(134,135,136,137,138,139,147,150,151,152,157,158,159,178,182,183,184,187,188),//移动
                            'unicom'=>array(130,131,132,155,156,186,185,145),//联通
                            'telecom'=>array(133,153,177,180,181,189,171,170),//电信
                        );
