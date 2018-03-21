<?php
/* Smarty version 3.1.30, created on 2017-07-12 08:07:44
  from "C:\wamp\www\sunnyp\tpl\information.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5965bcb0a9c868_14746061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff8b62534f819eb4b97e6673ce5963fdbfc7656a' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\information.html',
      1 => 1489042618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.html' => 1,
    'file:common/footer.html' => 1,
  ),
),false)) {
function content_5965bcb0a9c868_14746061 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link rel="stylesheet" type="text/css" href="/static/notice/css/cssReset.css"/>
    <link rel="stylesheet" type="text/css" href="/static/notice/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/notice/css/information.css"/>
</head>
<body>
<div class="container" align="center">
    <?php $_smarty_tpl->_subTemplateRender("file:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="entire">
        <div class="posses">
            <div class="status">
                <a class="apellation" href="/">首页</a>
                <a class="apellation active" href="javascript:;">热门资讯</a>
                <a class="apellation active" href="javascript:;"><?php if ($_smarty_tpl->tpl_vars['type']->value == 1) {?>活动公告<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 2) {?>公司动态<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 3) {?>回收资讯<?php }?></a>
            </div>

            <div class="dimension">
                <div class="left">
                    <div class="sidebar">
                        <a class="part" href="javascript:;">热门资讯</a>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['types']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <div class="restrain <?php if ($_smarty_tpl->tpl_vars['type']->value == $_smarty_tpl->tpl_vars['v']->value['id']) {?>active<?php }?>">
                                <a class="fame" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/news/Information/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a>
                            </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>

                    <div class="elite">推荐阅读</div>
                    <div class="groom">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rec_read']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <a class="headline" href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
">
                            <span>▪ </span>
                            <span><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</span>
                        </a>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <!-- <a class="headline" href="javascript:;">
                            <span>▪ </span>
                            <span>一大波品牌奢侈品包包正高能来袭</span>
                        </a>
                        <a class="headline" href="javascript:;">
                            <span>▪ </span>
                            <span>奢而不贵 | 正品价优才是正确选择</span>
                        </a>
                        <a class="headline" href="javascript:;">
                            <span>▪ </span>
                            <span>一大波品牌奢侈品包包正高能来袭</span>
                        </a>
                        <a class="headline" href="javascript:;">
                            <span>▪ </span>
                            <span>奢而不贵 | 正品价优才是正确选择</span>
                        </a> -->
                    </div>
                </div>

                <div class="right">
                    <div class="cream">
                        <div class="topic"><?php if ($_smarty_tpl->tpl_vars['type']->value == 1) {?>活动公告<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 2) {?>公司动态<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 3) {?>回收资讯<?php }?></div>
                    </div>
                    <div class="content">
                        <?php if ($_smarty_tpl->tpl_vars['texts']->value == false) {?>
                        <div>没有相关信息</div>
                        <?php } else { ?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['texts']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <a class="braised" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
/news/artical/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <div class="graphic">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img'];?>
"/>
                            </div>
                            <div class="detail">
                                <div class="title"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</div>
                                <div class="digest"><?php echo $_smarty_tpl->tpl_vars['v']->value['des'];?>
</div>
                                <div class="date">
                                    <span><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['v']->value['jtime']);?>
</span>
                                </div>
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

        </div>
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</div>

<?php echo '<script'; ?>
 type="text/javascript" src="/static/notice/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/notice/js/information.js"><?php echo '</script'; ?>
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
