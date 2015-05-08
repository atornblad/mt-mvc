<?php

class InputModelBuilder {
    /**
     * Builds an input model for a controller method
     * 
     * Performs analysis by reflection to determine how to build the input
     * model required by a controller method. Looks in request and route
     * information for the data necessary to build the input model. Builds
     * the input model.
     * 
     * @param ReflectionMethod $method
     * @param object $request
     * @param object $route
     * @return array
     */
    public function buildInputModel(ReflectionMethod $method, $request, $route) {
        $parameters = $method->getParameters();
        $parameterCount = count($parameters);
        
        if ($parameterCount === 0) {
            return [];
        }
        
        $result = [];
        
        foreach ($parameters as $index => $parameter) {
            $typeHint = $parameter->getClass();
            $name = $parameter->getName();
            
            // Trivial single-value input model named $id:
            if ($name == 'id' && !isset($typeHint) && $parameterCount === 1) {
                // This is the only time the $route->parameter is used!
                $value = @$route->parameter;
                
                if (isset($value)) {
                    return[$value];
                }
            }
            
            if (!isset($postData)) $postData = $request->post;
            
            if (!isset($typeHint)) {
                // Trivial single value from post
                if (isset($postData[$name])) {
                    $result[] = $postData[$name];
                }
            } else {
                // Type-hinted value
                $result[] = $this->buildTypeHintedObject($name, $typeHint, $postData);
            }
        }
        
        return $result;
    }
    
    private function buildTypeHintedObject($optionalPrefix, ReflectionClass $typeHint, array $postData) {
        $className = $typeHint->getName();
        $result = new $className;
        
        $properties = $typeHint->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            
            $prefixedName = "$optionalPrefix-$name";
            
            if (isset($postData[$prefixedName])) {
                $property->setValue($result, $postData[$prefixedName]);
            } else if (isset($postData[$name])) {
                $property->setValue($result, $postData[$name]);
            }
        }
        
        return $result;
    }
}

?>