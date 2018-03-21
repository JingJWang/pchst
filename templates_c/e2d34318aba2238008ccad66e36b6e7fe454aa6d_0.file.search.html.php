<?php
/* Smarty version 3.1.30, created on 2017-07-12 08:07:08
  from "C:\wamp\www\sunnyp\tpl\common\search.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5965bc8c1cff49_34863421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e2d34318aba2238008ccad66e36b6e7fe454aa6d' => 
    array (
      0 => 'C:\\wamp\\www\\sunnyp\\tpl\\common\\search.html',
      1 => 1489042618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5965bc8c1cff49_34863421 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <div class="trawled">
        <div class="search-box">
            <div class="search-rock">
                <div class="classify">
                    <?php if (!isset($_smarty_tpl->tpl_vars['other']->value['type']) || $_smarty_tpl->tpl_vars['other']->value['type'] == 'mobile') {?>
                    <span class="total" data='mobile'>手机</span>
                    <?php } elseif ($_smarty_tpl->tpl_vars['other']->value['type'] == 'flat') {?>
                    <span class="total" data='flat'>平板<span>
                    <?php }?>
                    <div class="categorize">
                        <a class="sort-name active" data='mobile' href="javascript:;">手机</a>
                        <a class="sort-name" data='flat' href="javascript:;">平板</a>
                    </div>
                </div>
                <input type="button" class="search"/>
                <div class="imports">
                    <input class="entry" type="text" placeholder="请输入要搜索的关键词"/ value="<?php if (isset($_smarty_tpl->tpl_vars['other']->value['search'])) {
echo $_smarty_tpl->tpl_vars['other']->value['search'];
}?>">
                </div>
            </div>
            <div class="version">
                <?php if (isset($_smarty_tpl->tpl_vars['hotSeach']->value) && !empty($_smarty_tpl->tpl_vars['hotSeach']->value)) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hotSeach']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <a class="model" target="_blank" href="/index.php/order/digital/option?id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
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
    </div><?php }
}
