<?php
require '../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty;

$smarty->assign("Name"   , "kakisoft", true);
$smarty->assign("message", "msg01"   , true);
$smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
    array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234"))
);

$smarty->display('sample01.tpl');

