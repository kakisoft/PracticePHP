<?php
$img = base64_encode(file_get_contents('sample_file_01.png'));
?>

<img src="data:image/jpg;base64, <?php echo $img; ?>">

<!--

php -S localhost:8000

http://localhost:8000/MyPHP06_base64.php

-->