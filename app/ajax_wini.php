<?php
require_once('../conf/global.conf');

$pic1 = CONFIG_LIB_URL."model/thumbnail.php/clintwinititus.jpg?width=180&height=225&cropratio=1:1.25&image=".CONFIG_IMG_URL."clintwinititus.jpg";
$photo = "<li class=\"large-avatar\"><img src=\"$pic1\" alt=\"love you mommy!\" /></li>";

echo $photo;
?>