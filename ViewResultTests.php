<?php

class ViewResultTests {
    /**
     * @test
     */
    public function ExecuteResultSetsCorrectContentType() {
        // Arrange
        $controllerName = 'Home';
        $viewName = 'Index';
        $model = null;
        
        // Create object
        $viewResult = new ViewResult($controllerName, $viewName, $model);
        
        // Set up expectations
        Expect($response)->toCall('setHeader')->withArguments(['Content-Type', 'text/html; charset=utf-8']);
        Expect($viewRootDir)->toCall('phpInclude')->withArguments(['home/index.php']);
        
        // Act
        $viewResult->executeResult($response, $viewRootDir);
        
        // Verify expectations
        $response->checkAll();
        $viewRootDir->checkAll();
    }
}

?>
