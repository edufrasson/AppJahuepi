<?php
spl_autoload_register(function($class){

    $arquivo = BASEDIR . '/' . $class. '.php'; 

    if(file_exists($arquivo))
        include $arquivo;
    else
        echo "Aquivo não encontrado: " . $arquivo;    
});