<?php
    spl_autoload_register('myAutoload');

    function myAutoload($classname){
        $path = 'include/';
        $ext = '.inc.php';
        $fullpath = $path.$classname.$ext;
        if (!file_exists($path)){
            echo 'Folder Classes Not Found';
            return false;
        }

        require $fullpath;
    }
