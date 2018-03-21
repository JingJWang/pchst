<?php
/* Smarty version 3.1.30, created on 2017-09-07 10:02:48
  from "C:\wamp\www\sunnyp\tpl\order\option.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b0fd280d1b59_08869444',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f8e4a8344438ce74a1049755e50f42a3294b7fcc' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\order\\option.html',
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
function content_59b0fd280d1b59_08869444 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>回收通—手机回收|二手手机回收|笔记本回收|奢侈品回收|数码产品回收|回收通官网</title>
    <meta name="keywords" content="数码回收  二手手机交易  二手手机网站   购买二手手机  数码产品回收  手机交易网"/>
    <meta name="description" content="闲置数码产品回收，为您提供安全专业的    二手手机、笔记本、平板电脑、数码相机等 回收交易、检测、评估服务"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/cssReset.css"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/home/css/informationChoice.css"/>
</head>
<body>
<div class="container" align="center">
    <?php $_smarty_tpl->_subTemplateRender("file:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <div class="entire">
        <div class="information">
            <div class="status">
                <a class="apellation" href="/">首页</a>
                <a class="apellation active" href="/index.php/recover/mobile">旧机回收</a>
                <a class="apellation active" href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['goodsInfo']->value[0]['types_name'];?>
</a>
            </div>
            <div class="posses">
                <div class="detail" style="padding-bottom:0px;">
                    <div class="info">
                        <div class="picture">
                            <img src="<?php if ($_smarty_tpl->tpl_vars['goodsInfo']->value[0]['types_img'] == '') {?>/static/recover/images/bdefault.png<?php } else {
echo $_smarty_tpl->tpl_vars['goodsInfo']->value[0]['types_img'];
}?>"/>
                        </div>
                        <div class="model"><?php echo $_smarty_tpl->tpl_vars['goodsInfo']->value[0]['types_name'];?>
</div>

                        <div class="amount">
                            <div class="outline">最高成交价</div>
                            <div class="sum">￥<?php echo $_smarty_tpl->tpl_vars['goodsInfo']->value[0]['types_maxprice'];?>
</div>
                        </div>
                        <div class="predict">
                            <span>预计下月跌幅：</span>
                        </div>
                        <div class="trend">
                            <div class="region">
                            </div>
                            <div class="current"></div>
                        </div>
                    </div>
                </div>
<form id="attr">
            <div class="property">
                    <div class="selecting">
                        <div class="epitome">基本信息</div>
                        <div class="assortment first">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['common_one']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                            <div class="raise">
                                <div class="tight"><?php echo $_smarty_tpl->tpl_vars['model']->value[$_smarty_tpl->tpl_vars['k']->value]['name'];?>
</div>
                                <a class="modify" href="javascript:;">修改</a>
                                <div class="average">
                                    <input type="text" class="name"  readonly="readonly"/>
                                    <input type="hidden" class="option" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                                </div>
                            </div>
                            <div class="choice">
                            	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
                                <a class="parameter <?php if (($_smarty_tpl->tpl_vars['i']->value+1)%4 == 0) {?>right<?php }?>" href="javascript:;">
                                    <span data-id="<?php echo $_smarty_tpl->tpl_vars['n']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value[$_smarty_tpl->tpl_vars['n']->value];?>
</span>
                                    <div class="pitch"></div>
                                </a>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </div>
                        </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['common']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <div class="assortment">
                            <div class="raise">
                                <div class="tight"><?php echo $_smarty_tpl->tpl_vars['model']->value[$_smarty_tpl->tpl_vars['k']->value]['name'];?>
</div>
                                <a class="modify" href="javascript:;">修改</a>
                                <div class="average">
                                    <input type="text" class="name" readonly="readonly"/>
                                    <input type="hidden" class="option" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                                </div>
                            </div>
                            <div class="choice">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
                                <a class="parameter <?php if (($_smarty_tpl->tpl_vars['i']->value+1)%4 == 0) {?>right<?php }?>" href="javascript:;">
                                    <span data-id="<?php echo $_smarty_tpl->tpl_vars['n']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value[$_smarty_tpl->tpl_vars['n']->value];?>
</span>
                                    <div class="pitch"></div>
                                </a>
                             <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
  
                            </div>
                        </div>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>
                    <div class="selecting">
                        <div class="epitome">外观成色</div>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['style_one']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <div class="assortment first">
                            <div class="raise">
                                <div class="tight"><?php echo $_smarty_tpl->tpl_vars['model']->value[$_smarty_tpl->tpl_vars['k']->value]['name'];?>
</div>
                                <a class="modify" href="javascript:;">修改</a>
                                <div class="average">
                                    <input type="text" class="name"  readonly="readonly"/>
                                    <input type="hidden" class="option" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                                </div>
                            </div>
                            <div class="choice">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
                                <a class="parameter <?php if (($_smarty_tpl->tpl_vars['i']->value+1)%4 == 0) {?>right<?php }?>" href="javascript:;">
                                    <span data-id="<?php echo $_smarty_tpl->tpl_vars['n']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value[$_smarty_tpl->tpl_vars['n']->value];?>
</span>
                                    <div class="pitch"></div>
                                </a>
                              <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    
                            </div>
                        </div>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['style']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <div class="assortment">
                            <div class="raise">
                                <div class="tight"><?php echo $_smarty_tpl->tpl_vars['model']->value[$_smarty_tpl->tpl_vars['k']->value]['name'];?>
</div>
                                <a class="modify" href="javascript:;">修改</a>
                                <div class="average">
                                    <input type="text" class="name" readonly="readonly"/>
                                    <input type="hidden" class="option" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                                </div>
                            </div>
                            <div class="choice">
                            	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
                                <a class="parameter <?php if (($_smarty_tpl->tpl_vars['i']->value+1)%4 == 0) {?>right<?php }?>" href="javascript:;">
                                    <span data-id="<?php echo $_smarty_tpl->tpl_vars['n']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value[$_smarty_tpl->tpl_vars['n']->value];?>
</span>
                                    <div class="pitch"></div>
                                </a>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </div>
                        </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>
                    <div class="other-problem">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['other']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <div class="prompt">
                            <span><?php echo $_smarty_tpl->tpl_vars['model']->value[$_smarty_tpl->tpl_vars['k']->value]['name'];?>
</span>
                            <span class="cue">(多选)</span>
                            <span class="cue" style="padding-left: 10px;">如无其他问题可不选</span>
                            <input type="hidden" id="other" class="option" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                        </div>
                        <div class="check">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
                            <div class="contain">
                                <div class="select-box" data-id="<?php echo $_smarty_tpl->tpl_vars['n']->value;?>
"></div>
                                <div class="words" ><?php echo $_smarty_tpl->tpl_vars['info']->value[$_smarty_tpl->tpl_vars['n']->value];?>
</div>
                            </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </div>
                    </div>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <div class="seize">
                        <a class="next-btn" href="javascript:;" onclick="submit();">下一步</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php $_smarty_tpl->_subTemplateRender("file:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</div>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="/static/home/js/informationChoice.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/home/ajax/r_common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/home/ajax/r_option.js"><?php echo '</script'; ?>
>
<!--  <?php echo '<script'; ?>
 type="text/javascript" src="/static/home/ajax/r_user.js"><?php echo '</script'; ?>
>-->
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
