<?php

$piecesUserId = explode(" ", preg_replace('/\s+/', ' ', trim($_GET['user_id'])));

print_r($piecesUserId);

// var_dump($comma_separated);
