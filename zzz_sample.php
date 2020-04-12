<?php

$fp = fopen('names.txt', 'a');

fwrite($fp, "jiro\n");
fwrite($fp, "saburo\n");

fclose($fp);
