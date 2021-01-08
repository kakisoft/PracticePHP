<?php
/* Smarty version 3.1.34-dev-5, created on 2018-10-17 15:17:46
  from '/vagrant/shared/www/PracticePHP/Smarty/Sample01/app/sample01.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-5',
  'unifunc' => 'content_5bc7529a57a945_36200926',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7e7e4341d52f3043e806a292300664de878f2037' => 
    array (
      0 => '/vagrant/shared/www/PracticePHP/Smarty/Sample01/app/sample01.tpl',
      1 => 1539789464,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bc7529a57a945_36200926 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
<title>Smarty Test</title>
</head>
<body>
<p>$smarty->assign("Name"   , "kakisoft", true);    ：<?php echo $_smarty_tpl->tpl_vars['Name']->value;?>
</p>
<p>$smarty->assign("message", "msg01"   , true);    ：<?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>

<ul>
    <?php
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? 3+1 - (1) : 1-(3)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration === 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration === $_smarty_tpl->tpl_vars['foo']->total;?>
        <li><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
　：　<?php echo sprintf('%02d',$_smarty_tpl->tpl_vars['foo']->value);?>
</li>
    <?php }
}
?>
</ul>


    <select name="year" id="year">
        <?php
$_smarty_tpl->tpl_vars['year'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['year']->step = 1;$_smarty_tpl->tpl_vars['year']->total = (int) ceil(($_smarty_tpl->tpl_vars['year']->step > 0 ? 2020+1 - (2018) : 2018-(2020)+1)/abs($_smarty_tpl->tpl_vars['year']->step));
if ($_smarty_tpl->tpl_vars['year']->total > 0) {
for ($_smarty_tpl->tpl_vars['year']->value = 2018, $_smarty_tpl->tpl_vars['year']->iteration = 1;$_smarty_tpl->tpl_vars['year']->iteration <= $_smarty_tpl->tpl_vars['year']->total;$_smarty_tpl->tpl_vars['year']->value += $_smarty_tpl->tpl_vars['year']->step, $_smarty_tpl->tpl_vars['year']->iteration++) {
$_smarty_tpl->tpl_vars['year']->first = $_smarty_tpl->tpl_vars['year']->iteration === 1;$_smarty_tpl->tpl_vars['year']->last = $_smarty_tpl->tpl_vars['year']->iteration === $_smarty_tpl->tpl_vars['year']->total;?>
            <option value="<?php echo $_smarty_tpl->tpl_vars['year']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</option>
        <?php }
}
?>
    </select>

    <select name="month" id="month">
        <?php
$_smarty_tpl->tpl_vars['month'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['month']->step = 1;$_smarty_tpl->tpl_vars['month']->total = (int) ceil(($_smarty_tpl->tpl_vars['month']->step > 0 ? 12+1 - (1) : 1-(12)+1)/abs($_smarty_tpl->tpl_vars['month']->step));
if ($_smarty_tpl->tpl_vars['month']->total > 0) {
for ($_smarty_tpl->tpl_vars['month']->value = 1, $_smarty_tpl->tpl_vars['month']->iteration = 1;$_smarty_tpl->tpl_vars['month']->iteration <= $_smarty_tpl->tpl_vars['month']->total;$_smarty_tpl->tpl_vars['month']->value += $_smarty_tpl->tpl_vars['month']->step, $_smarty_tpl->tpl_vars['month']->iteration++) {
$_smarty_tpl->tpl_vars['month']->first = $_smarty_tpl->tpl_vars['month']->iteration === 1;$_smarty_tpl->tpl_vars['month']->last = $_smarty_tpl->tpl_vars['month']->iteration === $_smarty_tpl->tpl_vars['month']->total;?>
            <option value="<?php echo sprintf('%02d',$_smarty_tpl->tpl_vars['month']->value);?>
" ><?php echo sprintf('%02d',$_smarty_tpl->tpl_vars['month']->value);?>
</option>
        <?php }
}
?>
    </select>

</body>
</html><?php }
}
