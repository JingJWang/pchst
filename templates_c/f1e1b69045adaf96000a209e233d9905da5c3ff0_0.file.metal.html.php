<?php
/* Smarty version 3.1.30, created on 2017-07-12 08:07:03
  from "C:\wamp\www\sunnyp\tpl\metal\metal.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5965bc8739af28_20834425',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1e1b69045adaf96000a209e233d9905da5c3ff0' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\metal\\metal.html',
      1 => 1489042618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.html' => 1,
    'file:common/message.html' => 1,
    'file:common/footer.html' => 1,
  ),
),false)) {
function content_5965bc8739af28_20834425 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>回收通|贵金属回收</title>
    <link rel="stylesheet" type="text/css" href="../../static/metal/css/cssReset.css"/>
    <link rel="stylesheet" type="text/css" href="../../static/metal/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="../../static/metal/css/preciousMetal.css"/>
</head>
<body onclick="Message.none();">
<div class="container" align="center">
     <?php $_smarty_tpl->_subTemplateRender("file:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <!--  <a class="advert" href="javascript:;">
        <img src="../../static/metal/images/adv.png"/>
    </a>-->
    <div class="entire">
        <div class="posses">
            <div class="notice">
                <span>交易时间为周一早7:00到周六早4:00</span>
            </div>
            <div class="category">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['metal']->value['type'], 'val', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                <?php if ($_smarty_tpl->tpl_vars['key']->value == 1) {?>
                <div class="classify active" align="center" metal-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="Matel.purity(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,this)">
                <?php } else { ?>
                <div class="classify " align="center" metal-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="Matel.purity(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,this)">
                <?php }?>
                    <div class="graphic">
                        <img src="../../static/metal/images/<?php echo $_smarty_tpl->tpl_vars['val']->value['img'];?>
"/>
                    </div>
                    <div class="breed"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</div>
                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <div class="wait">-敬请期待-</div>
            </div>
            <div class="recent">
            	当前黄金价格：<span id='matelprice_1'><?php echo $_smarty_tpl->tpl_vars['metal']->value['price']['1'];?>
</span>/克&nbsp&nbsp&nbsp&nbsp
            	铂金价格：<span id='matelprice_2'><?php echo $_smarty_tpl->tpl_vars['metal']->value['price']['2'];?>
</span>/克&nbsp&nbsp&nbsp&nbsp
            	白银价格：<span id='matelprice_3'><?php echo $_smarty_tpl->tpl_vars['metal']->value['price']['3'];?>
</span>/克&nbsp&nbsp&nbsp&nbsp
            	价格以最高纯度价格计算,其他纯度换算为最高纯度计算
            	</div>
                <div class="whole">
                    <div class="information">
                        <div class="dimension">
                            <div class="groups" id="purity">
                                <div class="raise">纯度</div>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['metal']->value['purity'], 'val', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                	<?php if ($_smarty_tpl->tpl_vars['key']->value == 1) {?> 
                                	<div class="choice" id="metal_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
                                	<?php } else { ?>
                                	<div class="choice" id="metal_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" style="display:none;">
                                	<?php }?>
                                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value, 'n', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['n']->value) {
?>
		                                   <?php if ($_smarty_tpl->tpl_vars['i']->value == 1) {?> 
		                                     <a class="parameter active" href="javascript:;" purity-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
		                                   <?php } else { ?>
		                                     <a class="parameter " href="javascript:;" purity-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
		                                   <?php }?>
		                                        <span><?php echo $_smarty_tpl->tpl_vars['n']->value;?>
</span>
		                                        <div class="pitch"></div>
		                                    </a>
                                	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                	</div>
                                 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                                
                            </div>
                        </div>
                        <div class="dimension">
                            <div class="groups">
                                <div class="raise">分类</div>
                                <div class="choice" id="classify">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['metal']->value['classify'], 'val', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                    	<?php if ($_smarty_tpl->tpl_vars['key']->value == 1) {?>
	                                    <a class="parameter active" href="javascript:;" classify-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
	                                    <?php } else { ?>
	                                    <a class="parameter " href="javascript:;" classify-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
	                                    <?php }?>
	                                        <span><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
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
                        </div>
                        <div class="dimension">
                            <div class="groups">
                                <div class="raise">克数</div>
                                <div class="reckon">
                                    <div class="convert">
                                        <a class="minus" href="javascript:;" onclick="Matel.price(-1)"></a>
                                        <a class="add" href="javascript:;" onclick="Matel.price(1)"></a>
                                        <div class="amount">
                                            <input class="grams" id="weight" type="text" value="0" onchange="Matel.price(0)"/>
                                        </div>
                                    </div>
                                    <div class="units">0.001kg</div>
                                </div>
                            </div>
                        </div>
                        <div class="recycle">
                            <div class="percent">
                                <span>回收总价：</span>
                                <span class="money"></span>
                            </div>
                        </div>
                    </div>
                    <div class="methods">
                        <div class="trade" id="dealtype">
                            <div class="words">交易方式</div>
                            <div class="pattern" style="margin-bottom: 38px;">
                                <a class="mode active" dealtype-id="D" href="javascript:;">添加到库存</a>
                                <div class="hints">提示：库存仅支持99.99%（24K）黄金，如果您的黄金纯度不够则按价格折算克数</div>
                            </div>
                            <div class="pattern">
                                <a class="mode" dealtype-id="A" href="javascript:;">我要现金</a>
                                <div class="hints">提示：最终价格以我们接收货物时价格为准您将获得现金</div>
                            </div>
                        </div>
                    </div>

                    <div class="indicate">
                        <div class="reveal">
                            <div class="total">
                                <span>回收总价：</span>
                                <span class="price"></span>
                            </div>
                            <a class="next-btn" href="javascript:;" onclick="Request.submit();">下一步</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <?php $_smarty_tpl->_subTemplateRender("file:common/message.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

 <?php $_smarty_tpl->_subTemplateRender("file:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</div>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/metal/js/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/metal/js/preciousMetal.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/home/ajax/r_common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../static/metal/js/metal.js"><?php echo '</script'; ?>
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
