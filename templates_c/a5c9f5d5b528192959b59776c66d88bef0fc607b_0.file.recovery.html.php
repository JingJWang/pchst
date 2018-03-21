<?php
/* Smarty version 3.1.30, created on 2017-07-12 08:07:08
  from "C:\wamp\www\sunnyp\tpl\recovery.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5965bc8c13b824_45201086',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5c9f5d5b528192959b59776c66d88bef0fc607b' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\recovery.html',
      1 => 1489042618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.html' => 1,
    'file:common/search.html' => 1,
    'file:common/footer.html' => 1,
  ),
),false)) {
function content_5965bc8c13b824_45201086 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['seo']->value['title'];?>
</title>
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['seo']->value['keyowrd'];?>
"/>
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['seo']->value['descript'];?>
"/>
    <link rel="stylesheet" type="text/css" href="/static/recover/css/cssReset.css"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/recover/css/digitalRecovery.css"/>
</head>
<body>
<div class="container" align="center">
    <?php $_smarty_tpl->_subTemplateRender("file:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php $_smarty_tpl->_subTemplateRender("file:common/search.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="entire">
        <div class="substance">
            <div class="status">
                <a class="apellation" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
">首页</a>
                <a class="apellation active" href="javascript:;">数码回收</a>
                <a class="apellation active" href="javascript:;">全部产品</a>
            </div>
            <div class="product">
                <div class="sidebar">
                    <a class="part" href="javascript:;">全部回收产品</a>
                    <div class="restrain <?php if ($_smarty_tpl->tpl_vars['other']->value['type'] == 'mobile') {?>active<?php }?>">
                        <a class="fame" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/mobile">手机</a>
                    </div>
                    <div class="restrain <?php if ($_smarty_tpl->tpl_vars['other']->value['type'] == 'flat') {?>active<?php }?>">
                        <a class="fame" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/flat">平板电脑</a>
                    </div>
                </div>
                
                <div class="exhibition" pnum=<?php echo $_smarty_tpl->tpl_vars['other']->value['p'];?>
 purl="<?php if (isset($_smarty_tpl->tpl_vars['other']->value['search'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/search/<?php echo (($_smarty_tpl->tpl_vars['other']->value['search']).('/')).($_smarty_tpl->tpl_vars['other']->value['type']);?>
/<?php } else { ?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/<?php echo (($_smarty_tpl->tpl_vars['other']->value['type']).('/b')).($_smarty_tpl->tpl_vars['other']->value['b']);?>
-p<?php }?>">
                    <div class="parade">
                        <div class="rise">品牌 :</div>
                        <div class="more-brands">
                            <span class="words">更多品牌</span>
                        </div>
                        <div class="rebrand">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brand']->value, 'v', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <a class="patch <?php if ($_smarty_tpl->tpl_vars['i']->value <= 6) {?>first<?php }?> <?php if ($_smarty_tpl->tpl_vars['other']->value['b'] == $_smarty_tpl->tpl_vars['v']->value['id']) {?>active<?php }?>" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/recover/<?php echo $_smarty_tpl->tpl_vars['other']->value['type'];?>
/b<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                                <div class="graph">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img'];?>
">
                                </div>
                                <div class="model-name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
                                <div class="line"></div>
                            </a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </div>
                    </div>

                    <div class="topical">
                        <div class="staple">热门</div>
                        <div class="more">
                            <span>更多</span>
                        </div>
                        <div class="hotlist">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['other']->value['hotmobile'], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <a class="phone-name" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/order/digital/option?id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><span class=""><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span></a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </div>
                    </div>

                    <div class="river">
                        <div class="brief">全部机型</div>
                        <div class="bonus">
                            <span>共</span>
                            <span class="sum"><?php echo $_smarty_tpl->tpl_vars['snum']->value['allnum'];?>
</span>
                            <span>个商品可参与回收</span>
                        </div>
                    </div>

                    <div class="possessive">
                        <?php if ($_smarty_tpl->tpl_vars['shops']->value != false) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shops']->value, 'v', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <a class="singleton <?php if (($_smarty_tpl->tpl_vars['i']->value+1)%6 == 0) {?>last<?php }?>" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/order/digital/option?id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <div class="print">
                                <img src="<?php if ($_smarty_tpl->tpl_vars['v']->value['img'] == '') {?>/static/recover/images/bdefault.png<?php } else {
echo $_smarty_tpl->tpl_vars['v']->value['img'];
}?>">
                            </div>
                            <div class="phone-name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
                            <div class="price">
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['mprice'] > 0) {?>
                                <span>回收价 :</span>
                                <span class="peg"><?php echo $_smarty_tpl->tpl_vars['v']->value['mprice'];?>
</span>
                                <span>元</span>
                                <?php }?>
                            </div>
                        </a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <?php } else { ?>
                        <div>未找到相关商品</div>
                        <?php }?>
                    </div>

                    <div class="pagination">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</div>
<?php echo '<script'; ?>
 src="/static/recover/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/recover/js/digitalRecovery.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/ajax/r_common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/js/search.js"><?php echo '</script'; ?>
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
