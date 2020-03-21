<?php

// $piecesUserId = explode(" ", preg_replace('/\s+/', ' ', trim($_GET['user_id'])));

// print_r($piecesUserId);

// // var_dump($comma_separated);



// preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
// print_r($matches);



$a1 = preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
// print_r($matches);
print_r($matches);



