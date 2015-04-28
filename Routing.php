<?php

class Routing {
    public $controllerClassName;
    public $methodName;
    public $parameter;
    
    /**
     * Processes a URL for MVC routing
     * 
     * Parses a URL into a controller part, a view part, and a parameter part.
     * All parts are optional. The controller and view parts have the default
     * values of Home and Index.
     * 
     * @param string $url The path part of a URL - after the initial /
     * @return object
     */
    public function handle($url) {
        $parts = explode('/', $url);
        
        $controllerName = @$parts[0];
        $methodName = @$parts[1];
        $parameter = @$parts[2];
        
        if (!$controllerName) $controllerName = 'Home';
        if (!$methodName) $methodName = 'Index';
        
        return (object) [
            'controllerName' => $controllerName,
            'controllerClassName' => $controllerName . 'Controller',
            'methodName' => $methodName,
            'parameter' => $parameter
        ];
    }
}

?>
