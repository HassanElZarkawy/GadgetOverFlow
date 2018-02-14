<?php

function autoload($path) {
    $items = glob($path . DIRECTORY_SEPARATOR . "*");
    foreach($items as $item) {
        $isPhp = pathinfo($item)["extension"] === "php";
        if (is_file($item) && $isPhp) {
            require_once $item;
        } elseif (is_dir($item)) {
            autoload($item);
        }
    }
}

autoload(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . "classes");


$loader = new Loader();
$controller = $loader->createController();
$controller->executeAction();
?>