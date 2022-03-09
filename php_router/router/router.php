<?php
require_once '../config/path.php';

function router($path) {

    var_dump($path);
    var_dump(ALLOWED_PATHS);
    var_dump(array_key_exists($path, ALLOWED_PATHS));
    $is_path = array_key_exists($path, ALLOWED_PATHS);
    
    if($is_path){
        var_dump('../'.BASE_CONTROLLER.ALLOWED_PATHS[$path].'.php');
        ob_start();
        require_once '../'.BASE_CONTROLLER.ALLOWED_PATHS[$path].'.php';
        $content = ob_get_clean();
        
    }
    return $content;
}