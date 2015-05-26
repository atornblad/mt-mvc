<?php

// Controller autoloader

spl_autoload_register(function ($fullClassName) {
    // Must be Namespace\Classname
    $parts = explode('\\', $fullClassName);
    $isTwoParts = (count($parts) == 2);
    if (!isTwoParts) return false;
    
    // Namespace must be 'Controllers'
    $namespaceName = $parts[0];
    $isControllersNamespace = ($namespaceName == 'Controllers');
    if (!isControllersNamespace) return false;
    
    // Class name must end with 'Controller'
    $className = $parts[1];
    $isControllerSuffix = (substr($className, -10) == 'Controller');
    if (!isControllerSuffix) return false;
    
    // Look for file here: DOCUMENT_ROOT/Controllers/classname.php
    $filename = $_SERVER['DOCUMENT_ROOT'] .
                DIRECTORY_SEPARATOR .
                'Controllers' .
                DIRECTORY_SEPARATOR .
                $className . '.php';
    
    // Does the file exist?
    if (!file_exists($filename)) return false;
    
    // Include the file. Done!
    require_once $filename;
    return true;
});

?>
