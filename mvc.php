<?php

require_once 'mvc-controller-autoloader.php';

// TODO: Consider putting framework classes in a dedicated namespace
// TODO: Write a good autoloader
require_once 'Routing.php';
require_once 'InputModelBuilder.php';
require_once 'ViewResult.php';

$requestedPath = $_GET['path'];

$routing = new Routing();
$route = $routing->handle($requestedPath);
$controllerClassName = 'Controllers\\' . $route->controllerClassName;

if (class_exists($controllerClassName)) {
    $controllerClass = new ReflectionClass($controllerClassName);
    
    if ($controllerClass->hasMethod($route->methodName)) {
        $controllerInstance = new $controllerClassName;
        
        $method = $controllerClass->getMethod($route->methodName);
        
        $inputModelBuilder = new InputModelBuilder;
        
        // TODO: Create $request instance first
        $inputModel = $inputModelBuilder->buildInputModel($method, $request, $route);
        
        $result = $method->invokeArgs($controllerInstance, $inputModel);
        
        // TODO: Create $response and $viewRootDir instances first
        $result->executeResult($response, $viewRootDir);
    } else {
        // Non-existing method!
        // Respond with 404 Not Found
    }
} else {
    // Non-existing controller!
    // Respond with 404 Not Found
}

?>
