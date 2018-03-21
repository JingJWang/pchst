<?php
/* Smarty version 3.1.30, created on 2017-05-22 05:11:35
  from "C:\wamp\www\sunnyp\tpl\home.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_592256e7b24f37_97899138',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef330e2b1655567657d81736d74d838ac516bac4' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\home.html',
      1 => 1493975922,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.html' => 1,
    'file:common/footer.html' => 1,
  ),
),false)) {
function content_592256e7b24f37_97899138 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "common.conf", null, 0);
?>

<?php
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "seo.conf", null, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'indexTitle');?>
</title>
    <meta name="keywords" content="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'indexKeyword');?>
"/>
    <meta name="description" content="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'indexDescript');?>
"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/cssReset.css"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/index.css"/>
</head>
<body>
<div class="container" align="center">
    <?php $_smarty_tpl->_subTemplateRender("file:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="banner">
        <div class="viewport">
            <a data-index="1" class="graphic" href="javascript:;"></a>
            <a data-index="2" class="graphic" style="margin-left: 100%;" href="javascript:;"></a>
            <a data-index="3" class="graphic" style="margin-left: 200%;" href="javascript:;"></a>
            <a data-index="4" class="graphic" style="margin-left: 300%" href="javascript:;"></a>
            <a data-index="5" class="graphic" style="margin-left: 400%;" href="javascript:;"></a>
            <a data-index="6" class="graphic" style="margin-left: 500%;" href="javascript:;"></a>
        </div>
        <div class="upper" align="center">
            <div class="dimension">
                <div class="emphases">
                    <div class="search-level">
                        <div class="search-rock">
                            <div class="classify">
                                <span class="total" data='mobile'>手机</span>
                                <div class="categorize">
                                    <a class="sort-name active" data='mobile' href="javascript:;">手机</a>
                                    <a class="sort-name" data='flat' href="javascript:;">平板</a>
                                </div>
                            </div>
                            <input type="button" class="search"/>
                            <div class="imports">
                                <input class="entry" type="text" placeholder="请输入要回收的机型"/>
                            </div>
                        </div>
                        <div class="hot-search">
                            <div class="rout">热搜 :</div>
                            <div class="version">
                                <?php if (!empty($_smarty_tpl->tpl_vars['hotSeach']->value)) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hotSeach']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <a class="model" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/order/digital/option?id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="dataReveal">
                        <div class="theme">回收通成交数据</div>
                        <div class="particulars">
                            <div class="turnover">
                                <div class="apellation">成交金额 :</div>
                                <div class="amount">
                                    <span class="unit" id="volume"><?php echo $_smarty_tpl->tpl_vars['deal']->value['volume'];?>
</span>
                                </div>
                            </div>
                            <div class="singular">
                                <div class="deal">成交单数 :</div>
                                <div class="integer">
                                    <span class="num" id="number"><?php echo $_smarty_tpl->tpl_vars['deal']->value['number'];?>
</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sprawls">
                    <div class="tier">
                        <div data-id="0" class="dot first active"></div>
                        <div data-id="1" class="dot"></div>
                        <div data-id="2" class="dot"></div>
                        <div data-id="3" class="dot"></div>
                        <div data-id="4" class="dot"></div>
                        <div data-id="5" class="dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mainstay">
        <div class="entire">
            <div class="subtitle">
                热门回收
                <div class="left-line"></div>
                <div class="right-line"></div>
            </div>
            <div class="variety">
                <div class="model-bar">
                    <div class="palette">
                        <input class="group active" style="cursor:pointer" type="button" data-id='5' value="手机"/>
                        <input class="group" style="cursor:pointer" type="button" data-id='7' value="平板"/>
                    </div>
                    <div class="inquired">
                    <?php if ($_smarty_tpl->tpl_vars['brand']->value != false) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brand']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <a class="classification names" data-id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
 href="javascript:;">
                            <div class="graph">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img'];?>
" alt="二手手机回收"/>
                            </div>
                            <div class="plate"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
                                <div class="line"></div>
                            </a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <a class="classification" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/mobile">
                            <div class="graph">
                                <div class="tier">
                                    <div class="ong first"></div>
                                    <div class="ong"></div>
                                    <div class="ong"></div>
                                </div>
                            </div>
                            <div class="plate">全部品牌</div>
                        </a>
                    <?php }?>
                    </div>
                </div>
                <div class="tabulation">
                    <?php if ($_smarty_tpl->tpl_vars['shops']->value != false) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shops']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <a class="singleton" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/order/digital/option?id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <div class="print">
                                <img src="<?php if ($_smarty_tpl->tpl_vars['v']->value['img'] == '') {?>/static/recover/images/bdefault.png<?php } else {
echo $_smarty_tpl->tpl_vars['v']->value['img'];
}?>" alt="二手手机回收"/>
                            </div>
                            <div class="design"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
                            <div class="explicit">
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['mprice'] > 0) {?>
                                <span>回收价 :</span>
                                <span class="money">￥<?php echo $_smarty_tpl->tpl_vars['v']->value['mprice'];?>
</span>
                                <?php }?>
                            </div>
                        </a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php }?>
                </div>
            </div>
        </div>

        <div class="luxury">
            <div class="categories">
                <a class="name active" target="_blank" href="http://www.91jst.com/">
                    <span class="appear active">奢侈品寄售/回收</span>
                </a>
                <!-- <a class="name" href="javascript:;">
                    <span style="border:0;">箱包</span>
                </a>
                <a class="name" href="javascript:;">
                    <span>腕表</span>
                </a>
                <a class="name" href="javascript:;">
                    <span>饰品</span>
                </a>
                <a class="name" href="javascript:;">
                    <span>皮带</span>
                </a>
                <a class="more" href="javascript:;">
                    <span>更多</span>
                </a> -->
            </div>

            <div class="brands">
                <a class="rocky" target="_blank" href="http://www.91jst.com/">
                    <div class="ratio">
                        <img src="/static/home/images/jst/5-5.jpg" alt="二手手机回收" alt="二手手机回收"/>
                    </div>
                    <div class="comprise">
                        <div class="brands-logo">
                            <img src="/static/home/images/jst/5.jpg" alt="二手手机回收" alt="二手手机回收"/>
                        </div>
                        <div class="short">
                            <div class="brand-name">HERMES(爱马仕) 蓝色皮质金扣Birkin35手提包</div>
                            <div class="average">
                                <span>寄售价 :</span>
                                <span class="sam">￥81500.00</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="rocky" target="_blank" href="http://www.91jst.com/">
                    <div class="ratio">
                        <img src="/static/home/images/jst/1-1.jpg" alt="二手手机回收"/>
                    </div>
                    <div class="comprise">
                        <div class="brands-logo">
                            <img src="/static/home/images/jst/1.jpg" alt="二手手机回收"/>
                        </div>
                        <div class="short">
                            <div class="brand-name">白三彩铆钉装饰手提包 YH</div>
                            <div class="average">
                                <span>寄售价 :</span>
                                <span class="sam">￥6200.00</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="rocky" target="_blank" href="http://www.91jst.com/">
                    <div class="ratio">
                        <img src="/static/home/images/jst/2-2.jpg" alt="二手手机回收"/>
                    </div>
                    <div class="comprise">
                        <div class="brands-logo">
                            <img src="/static/home/images/jst/2.jpg"/>
                        </div>
                        <div class="short">
                            <div class="brand-name">女士山羊皮铆钉镶嵌单肩包 SP</div>
                            <div class="average">
                                <span>回收价 :</span>
                                <span class="sam">￥5868.00</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="rocky" target="_blank" href="http://www.91jst.com/">
                    <div class="ratio">
                        <img src="/static/home/images/jst/3-3.jpg" alt="二手手机回收"/>
                    </div>
                    <div class="comprise">
                        <div class="brands-logo">
                            <img src="/static/home/images/jst/3.jpg" alt="二手手机回收"/>
                        </div>
                        <div class="short">
                            <div class="brand-name">蓝色皮质公文包</div>
                            <div class="average">
                                <span>回收价 :</span>
                                <span class="sam">￥8380.00</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="rocky" target="_blank" href="http://www.91jst.com/">
                    <div class="ratio">
                        <img src="/static/home/images/jst/4-4.jpg" alt="二手手机回收"/>
                    </div>
                    <div class="comprise">
                        <div class="brands-logo">
                            <img src="/static/home/images/jst/4.jpg" alt="二手手机回收"/>
                        </div>
                        <div class="short">
                            <div class="brand-name">蓝色印花帆布手提包</div>
                            <div class="average">
                                <span>寄售价 :</span>
                                <span class="sam">￥2300.00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="storey">
            <div class="goodness">
                <div class="mouthful">
                    我们的优势
                    <div class="left-line"></div>
                    <div class="right-line"></div>
                </div>
                <div class="advantage"></div>
            </div>
        </div>

        <div class="superiority">
            <div class="comprise">
                <div data-index="1" class="votes">
                    <span>竞价回收，高价无忧</span>
                </div>
                <div data-index="2" class="votes">
                    <span>平台担保，货款先行</span>
                </div>
                <div data-index="3" class="votes">
                    <span>安全回收，隐私清除</span>
                </div>
                <div data-index="4" class="votes">
                    <span>专业回收，优质服务</span>
                </div>
            </div>
        </div>

        <div class="extra">
            <div class="nominate">
                <div class="journalism">
                    <div class="adult">
                        <div class="briefed">热门资讯</div>
                        <a target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/news/Information/24"><input class="check" type="button" value="查看更多"/></a>
                    </div>
                    <div class="substance">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['information']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <div class="press">
                            <a target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/news/artical/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                                <div class="headline"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</div>
                                <div class="covers">
                                    <p class="words"><?php if (strlen($_smarty_tpl->tpl_vars['v']->value['content']) > 147) {
echo mb_substr($_smarty_tpl->tpl_vars['v']->value['content'],0,49,'UTF8');?>
...<?php } else {
echo $_smarty_tpl->tpl_vars['v']->value['content'];
}?></p>
                                    <input class="more" type="button" value="更多"/>
                                </div>
                            </a>
                        </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>
                </div>
                <div class="discuss">
                    <div class="title">用户评论</div>
                    <div class="map">
                        <div class="atlas">
                        </div>
                    </div>
                </div>
            </div>
            <div class="ground">合作伙伴
                <div class="left-line"></div>
                <div class="right-line"></div>
            </div>
            <div class="cooperate">
                <div class="single">
                    <div class="content">
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner9.png"/>
                            </div>
                            <div class="industry">中科招商</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner1.png"/>
                            </div>
                            <div class="industry">百度创业中心</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner2.png"/>
                            </div>
                            <div class="industry">天津贵金属交易所</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner3.png"/>
                            </div>
                            <div class="industry">北大科技园</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner4.png"/>
                            </div>
                            <div class="industry">北京大学创业训练营</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner5.png"/>
                            </div>
                            <div class="industry">北京电视台</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner6.png"/>
                            </div>
                            <div class="industry">北京南洋林德投资</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner7.png"/>
                            </div>
                            <div class="industry">北京长城金点投资</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner8.png"/>
                            </div>
                            <div class="industry">北京服装学院</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner9.png"/>
                            </div>
                            <div class="industry">中科招商</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner1.png"/>
                            </div>
                            <div class="industry">百度创业中心</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner2.png"/>
                            </div>
                            <div class="industry">天津贵金属交易所</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner3.png"/>
                            </div>
                            <div class="industry">北大科技园</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner4.png"/>
                            </div>
                            <div class="industry">北京大学创业训练营</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner5.png"/>
                            </div>
                            <div class="industry">北京电视台</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner6.png"/>
                            </div>
                            <div class="industry">北京南洋林德投资</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner7.png"/>
                            </div>
                            <div class="industry">北京长城金点投资</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner8.png"/>
                            </div>
                            <div class="industry">北京服装学院</div>
                        </div>
                        <div class="partnership">
                            <div class="partners">
                                <img src="/static/home/images/patner9.png"/>
                            </div>
                            <div class="industry">中科招商</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $_smarty_tpl->_subTemplateRender("file:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        
        <div class="stanav">
            <div class="trade">
                <a data-index="1" class="abilities phone-deal" href="javascript:;"> 手机交易
                    <div class="horn"></div>
                    <div class="attention">
                        <div class="stack">
                            <img src="/static/home/images/recover.png" alt="二手手机回收"/>
                        </div>
                        <p class="swept">扫一扫关注微信用手机完成交易</p>
                    </div>
                </a>
                <a data-index="2" class="abilities customService" href="javascript:;">联系客服
                    <div class="horn"></div>
                    <div class="contactWay">
                        <div class="telephone">
                            <span>400-641-5080</span>
                        </div>
                        <div class="time">周一至周日：09:00-19:00</div>
                    </div>
                </a>
                <!-- <a data-index="3" class="abilities" href="javascript:;">邀请领奖</a> -->
            </div>
            <a class="roof" href="javascript:;"></a>
        </div>
    </div>
</div>

<!-- <div class="shadow"></div>
<div class="inform">
    <img src="/static/home/images/bg_01.png"/>
    <a class="close-btn" href="javascript:;"></a>
</div> -->

<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/ajax/r_common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/js/index.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/ajax/r_brand.js"><?php echo '</script'; ?>
>
<!-- 百度统计 -->
<?php echo '<script'; ?>
>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?7a5cf99280e27b3d044898fc2df5ca24";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
