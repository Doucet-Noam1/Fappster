<?php
include_once("Album.php");
include_once("../bd.php");
$b=new BD();
$a = new Album("test",[],"2020","test");
$a->render();

?>