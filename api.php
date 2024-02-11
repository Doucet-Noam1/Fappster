<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

header('Content-Type: application/json; charset=utf-8');
$res["data"] = [null];
if (isset($_GET['sortie'])) {
    if (isset($_GET['id'])){
        $res = array_map(function($artiste) {return $artiste->__toJson();}, BD::rechercheArtiste($_GET['id']));
    } else {
        // jsp faudra faire qq chose ici
    }
}
echo json_encode($res);