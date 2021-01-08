<?php

$_SESSION["redirect_params"] = "";

$filterdParms = array_filter($_GET, function($k){ return $k != "mode";}, ARRAY_FILTER_USE_KEY);

if (count($filterdParms) > 0){
    $connectedParams = [];
    foreach ($filterdParms as $k => $v) {
        array_push($connectedParams, "{$k}={$v}");
    }
    $serializedParam = implode("&", $connectedParams);

    $_SESSION["redirect_params"] = $serializedParam;
}

echo "<br>===================<br>";
var_dump($filterdParms);
var_dump($connectedParams);
var_dump($serializedParam);
echo "<br>===================<br>";

