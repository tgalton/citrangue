<?php
// This class is use to different purpose relatives to redirection and determine existings paths/url
namespace Services\allClass;

class PathsFinder 
{
    // ***** Variable+Const to router *****//
    public const DEFAULT_PATH = 'firstPage';
    public const BASE_CONTROLLER = 'app/controllers/';
    public $allowedPaths;

    // getAllPaths is only use to define $allowedPaths
    // getAllPaths stock an array into $allowedPaths : a list of all the paths get[url] -> controllers
    public function getAllPaths()
    {
        // var_dump("hello getAllPaths");
        // $allPaths and $allNamesPaths are use into getAllPaths
        $allPaths = [];
        $allNamesPaths = [];
        $allViews = scandir('../app/views');
        // Cut .phtml from views name
        foreach($allViews as $oneView){
            array_push($allNamesPaths, substr_replace($oneView,"", -6));
        }
        // add Controller.php
        foreach($allNamesPaths as $oneNamePath){
            $allPaths += [$oneNamePath => self::BASE_CONTROLLER.$oneNamePath."Controller.php"];
        }
        foreach($allPaths as $key=>$path)
        {
            if(strlen($key)<1){
                unset($allPaths[$key]);
            };
        }

        $allPaths += ["formAPI" => "app/API/formAPI.php"];
        $this->allowedPaths = $allPaths;
        
    }

    public function router($pathFromUrl) {
        // Better be router inside the class PathsFinder.
        $is_pathFromUrl = array_key_exists($pathFromUrl, $this -> allowedPaths);
        if($is_pathFromUrl){
            ob_start();
            
            
            require_once '../'.$this->allowedPaths[$pathFromUrl] ;

            
            $content = ob_get_clean();
        }
        return $content;
    }
}