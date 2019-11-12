<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type: text/xml");

echo('<?xml version="1.0" encoding="UTF-8" ?>');
echo('<test><page><name>Google</name><url>http://google.co.jp</url></page></test>');
