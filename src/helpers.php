<?php
/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 8/27/17
 * Time: 2:24 PM
 */
namespace Papioniha\AuthorizationServerClient{
    function isInstanceOf($object, $interface){
        $object_methods = get_class_methods($object);
        $interface_reflection = new \ReflectionClass($interface);
        $interface_methods = $interface_reflection->getMethods();
        foreach ($interface_methods as $method){
            if(!in_array($method->name, $object_methods)){
                return false;
            }
        }
        return true;
    }
}