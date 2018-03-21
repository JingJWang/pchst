<?php
/* Smarty version 3.1.30, created on 2017-05-22 05:11:35
  from "C:\wamp\www\sunnyp\tpl\common\header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_592256e7de8062_48827731',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5f885d8b3f7be73e17014e1b31a84e547f6c7f1' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\common\\header.html',
      1 => 1489042618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_592256e7de8062_48827731 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="navigation">
	<div class="navigation-bar">
		<h1>
			<a class="logo" title="回收通—二手手机回收" href="http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];?>
">
				<img src="/static/home/images/logo2.png" alt="二手手机回收"/>
			</a>
		</h1>
		<a class="logoWord" href="/">价值驱动环保</a>
		<div class="genre">
			<div class="classify">
				<a class="className <?php if ($_smarty_tpl->tpl_vars['header']->value['sign'] == 'home') {?>active<?php }?>"  href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/">首页</a> 
				<a class="className <?php if ($_smarty_tpl->tpl_vars['header']->value['sign'] == 'mobile') {?>active<?php }?>" href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/recover/mobile">数码回收</a> 
				<a class="className <?php if ($_smarty_tpl->tpl_vars['header']->value['sign'] == 'luxuries') {?>active<?php }?>" href="javascript:;">奢侈品寄售/回收</a>
				<a class="className <?php if ($_smarty_tpl->tpl_vars['header']->value['sign'] == 'metal') {?>active<?php }?>"  href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/metal/metal/">贵金属回收</a>
				<a class="className <?php if ($_smarty_tpl->tpl_vars['header']->value['sign'] == 'shop') {?>active<?php }?>"   href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/shops/shopinfo/">通花商城</a>
			</div>
			
			<?php if ($_smarty_tpl->tpl_vars['top']->value['name'] != '') {?>
			<div class="facility">
				<div class="head-ion">
					<img src="<?php echo $_smarty_tpl->tpl_vars['top']->value['photo'];?>
" alt="二手手机回收"/>
				</div>
				<div class="consumer"><a style="color:#3668ce;" href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/center/info"><?php if ($_smarty_tpl->tpl_vars['top']->value['name'] == '') {?>个人信息<?php } else {
echo $_smarty_tpl->tpl_vars['top']->value['name'];
}?></a>&nbsp;&nbsp;<a href="JavaScript:;" onclick="loginOut();">退出</a></a>
				</div>
			</div>
			<?php } else { ?>
			<div class="facility">
				<div class="head-ion">
					<img src="/static/recover/images/avatar.png" alt="二手手机回收"/>
				</div>
				<div class="consumer">
					<input class="login" type="button" onclick="javascript:window.location.href='<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/user/login'"value="登录" /> 
					<input class="register" type="button" onclick="javascript:window.location.href='<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/user/register'"value="注册" />
				</div>
			</div>
			<?php }?>
			
		</div>
	</div>
</div>
<div class="full-top"></div><?php }
}
