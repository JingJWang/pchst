<?php
/* Smarty version 3.1.30, created on 2017-05-22 05:11:35
  from "C:\wamp\www\sunnyp\tpl\common\footer.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_592256e7e65073_95720809',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4236d6f09322dd15e499c633b4a0354eb5d978fd' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\common\\footer.html',
      1 => 1493977518,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_592256e7e65073_95720809 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="page-bottom">
        <div class="footer">
            <div class="footer-left">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['foots']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <div class="column">
                    <div class="rise"><a target="_blank" href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/news/getnotice/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></div>
                    <?php if (isset($_smarty_tpl->tpl_vars['v']->value['son'])) {?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['son'], 'son');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['son']->value) {
?>
                    <a class="lets" target="_blank" href="<?php if (isset($_smarty_tpl->tpl_vars['seo']->value['host_name'])) {?>http://<?php echo $_smarty_tpl->tpl_vars['seo']->value['host_name'];
}?>/news/getnotice/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/#link<?php echo $_smarty_tpl->tpl_vars['son']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['son']->value['title'];?>
</a>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php }?>
                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
            <div class="footer-right">
                <div class="relation">联系我们</div>
                <div class="contact">
                    <span class="tel">400-641-5080</span>
                    <span class="timer">周一至周日：09:00-19:00</span>
                </div>
                <!-- <div class="addr">地址：北京市朝阳区惠新西街北口千鹤家园1号楼904</div> -->
                <div class="concern">
                    <div class="concern-left">
                        <div class="code">
                            <img src="/static/home/images/recover.png" alt="二手手机回收"/>
                        </div>
                        <div class="stamp">扫码关注【回收通】</div>
                    </div>
                    <div class="concern-left">
                        <div class="code">
                            <img src="/static/home/images/consign.png" alt="二手手机回收"/>
                        </div>
                        <div class="stamp">扫码关注【寄售通】</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">©Copyright 2014-2016 All Right Reserved   京ICP备14055664号-1； 北京知通科技有限公司   </div>
    </div><?php }
}
