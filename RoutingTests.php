<?php

class RoutingTests {
    /**
     * @test
     */
    public function CheckAllDefaults() {
        // Arrange
        $routing = new Routing();
        
        // Act
        $route = $routing->handle('');
        
        // Assert
        The($route->controllerClassName)->shouldEqual('HomeController');
        The($route->methodName)->shouldEqual('Index');
        The($route->parameter)->shouldNotBeSet();
    }
    
    /**
     * @test
     */
    public function CheckDefaultMethodNameAndParameter() {
        // Arrange
        $routing = new Routing();
        
        // Act
        $route = $routing->handle('Articles');
        
        // Assert
        The($route->controllerClassName)->shouldEqual('ArticlesController');
        The($route->methodName)->shouldEqual('Index');
        The($route->parameter)->shouldNotBeSet();
    }
    
    /**
     * @test
     */
    public function CheckDefaultParameter() {
        // Arrange
        $routing = new Routing();
        
        // Act
        $route = $routing->handle('Categories/List');
        
        // Assert
        The($route->controllerClassName)->shouldEqual('CategoriesController');
        The($route->methodName)->shouldEqual('List');
        The($route->parameter)->shouldNotBeSet();
    }
    
    /**
     * @test
     */
    public function CheckNoDefaults() {
        // Arrange
        $routing = new Routing();
        
        // Act
        $route = $routing->handle('Products/Item/123x');
        
        // Assert
        The($route->controllerClassName)->shouldEqual('ProductsController');
        The($route->methodName)->shouldEqual('Item');
        The($route->parameter)->shouldEqual('123x');
    }
}

?>
