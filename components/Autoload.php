<?php

spl_autoload_register(function ($name) {

    $paths = [
        '/components/',
        '/models/'
    ];

    foreach ($paths as $path) {
        $classPath  = ROOT . $path  . $name  . '.php';

        if(file_exists($classPath)) {
            require_once($classPath);
        }
    }

});
