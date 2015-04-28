<?php

class ViewResult {
    private $controllerName;
    private $viewName;
    
    /**
     * @param string $controller Name of the controller, not the controller class, so this is without the *Controller suffix
     * @param string $viewName Name of the view, used to find the correct view .php file
     * @param mixed $model
     */
    public function __construct($controllerName, $viewName, $model) {
        $this->controllerName = $controllerName;
        $this->viewName = $viewName;
    }
    
    /**
     * Renders a HTML view
     *
     * @param HttpResponseWrapper $response
     * @param FileSystemWrapper $viewRootDir
     * 
     * @return void
     */
    public function executeResult($response, $viewRootDir) {
        // Set HTTP response headers
        $response->setHeader('Content-Type', 'text/html; charset=utf-8');
        
        // Include the .php file in the view directory
        $viewRootDir->phpInclude(mb_strtolower($this->controllerName) . '/' . mb_strtolower($this->viewName) . '.php');
    }
}


?>