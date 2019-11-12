<?php
$content = json_decode(file_get_contents("http://challenge-your-limits.herokuapp.com/call/me"));

var_dump($content);
