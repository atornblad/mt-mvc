<?php

class InputModelBuilderTests {
    /**
     * @test
     */
    public function ReturnsNullForMethodWithoutParameters() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('NoParametersMethod');
        
        // No expected calls to request or route!
        Expect($route);
        Expect($request);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        The($result)->ShouldEqual([]);
    }
    
    /**
     * @test
     */
    public function ReturnsRouteParameterForSimpleParameterMethod() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('SimpleParameterMethod');
        
        // No expected calls to request!
        Expect($route)->toGet('parameter', 'abc.123');
        Expect($request);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        $route->checkAll();
        $request->checkAll();
        
        The($result)->ShouldEqual(['abc.123']);
    }
    
    /**
     * @test
     */
    public function ReturnsPostIdForSimpleParameterMethod() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('SimpleParameterMethod');
        
        Expect($route)->toGet('parameter', null);
        Expect($request)->toGet('post', ['id' => 'abc.123']);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        $route->checkAll();
        $request->checkAll();
        
        The($result)->ShouldEqual(['abc.123']);
    }
    
    /**
     * @test
     */
    public function ReturnsPostDataForTwoSimpleParametersMethod() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('TwoSimpleParametersMethod');
        
        // No expected calls to route!
        Expect($route);
        Expect($request)->toGet('post', ['bar' => 'QWER', 'foo' => 'ASDF']);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        $route->checkAll();
        $request->checkAll();
        
        The($result)->ShouldEqual(['ASDF', 'QWER']);
    }
    
    /**
     * @test
     */
    public function ReturnsNonprefixedPostDataForComplexParameterMethod() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('SmallInputModelMethod');
        
        // No expected calls to route!
        Expect($route);
        Expect($request)->toGet('post', ['bar' => 'QWER', 'foo' => 'ASDF']);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        $route->checkAll();
        $request->checkAll();
        
        The(count($result))->ShouldBeExactly(1);
        The($result[0])->ShouldBeInstanceOf(\ImbtSmallInputModel::class);
        The($result[0]->foo)->ShouldEqual('ASDF');
        The($result[0]->bar)->ShouldEqual('QWER');
    }
    
    /**
     * @test
     */
    public function ReturnsPrefixedPostDataForComplexParameterMethod() {
        // Arrange
        $class = new \ReflectionClass(ImbtControllerDummy::class);
        $method = $class->getMethod('SmallInputModelMethod');
        
        // No expected calls to route!
        Expect($route);
        Expect($request)->toGet('post', ['model-bar' => 'QWER', 'model-foo' => 'ASDF']);
        
        // Act
        $builder = new InputModelBuilder();
        $result = $builder->buildInputModel($method, $request, $route);
        
        // Assert
        $route->checkAll();
        $request->checkAll();
        
        The(count($result))->ShouldBeExactly(1);
        The($result[0])->ShouldBeInstanceOf(\ImbtSmallInputModel::class);
        The($result[0]->foo)->ShouldEqual('ASDF');
        The($result[0]->bar)->ShouldEqual('QWER');
    }
}

class ImbtControllerDummy {
    public function NoParametersMethod() {
    }
    
    public function SimpleParameterMethod($id) {
    }
    
    public function TwoSimpleParametersMethod($foo, $bar) {
    }
    
    public function SmallInputModelMethod(ImbtSmallInputModel $model) {
    }
}

class ImbtSmallInputModel {
    public $foo;
    public $bar;
}

?>
